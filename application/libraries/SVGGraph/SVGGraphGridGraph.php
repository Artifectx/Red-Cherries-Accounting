<?php
/**
 * Copyright (C) 2009-2018 Graham Breach
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
/**
 * For more information, please contact <graham@goat1000.com>
 */

require_once 'SVGGraphAxis.php';

abstract class GridGraph extends Graph {

  protected $x_axes;
  protected $y_axes;
  protected $main_x_axis = 0;
  protected $main_y_axis = 0;
  protected $y_axis_positions = array();

  /**
   * Set to true for horizontal graphs
   */
  protected $flip_axes = false;

  /**
   *  Set to true for block-based labelling
   */
  protected $label_centre = false;

  /**
   * Set to true for graphs that don't support multiple axes (e.g. stacked)
   */
  protected $single_axis = false;

  protected $crosshairs = null;
  protected $g_width = null;
  protected $g_height = null;
  protected $label_adjust_done = false;
  protected $axes_calc_done = false;
  protected $guidelines;
  protected $min_guide = array('x' => null, 'y' => null);
  protected $max_guide = array('x' => null, 'y' => null);

  private $label_left_offset;
  private $label_bottom_offset;
  private $label_right_position = array();
  private $label_top_offset;
  private $grid_limit;
  private $grid_clip_id;

  /**
   * Modifies the graph padding to allow room for labels
   */
  protected function LabelAdjustment()
  {
    $grid_l = $grid_t = $grid_r = $grid_b = NULL;

    $grid_set = $this->GetFirst($this->grid_left, $this->grid_right,
      $this->grid_top, $this->grid_bottom);
    if($grid_set) {
      if(!empty($this->grid_left))
        $grid_l = $this->pad_left = abs($this->grid_left);
      if(!empty($this->grid_top))
        $grid_t = $this->pad_top = abs($this->grid_top);
      
      if(!empty($this->grid_bottom))
        $grid_b = $this->pad_bottom = $this->grid_bottom < 0 ?
          abs($this->grid_bottom) : $this->height - $this->grid_bottom;
      if(!empty($this->grid_right))
        $grid_r = $this->pad_right = $this->grid_right < 0 ?
          abs($this->grid_right) : $this->width - $this->grid_right;
    }

    // deprecated options need converting
    // NOTE: this works because graph settings become properties, whereas
    // defaults only exist in the $this->settings array
    if(isset($this->show_label_h) && !isset($this->show_axis_text_h))
      $this->show_axis_text_h = $this->show_label_h;
    if(isset($this->show_label_v) && !isset($this->show_axis_text_v))
      $this->show_axis_text_v = $this->show_label_v;

    // if the label_x or label_y are set but not _h and _v, assign them
    $lh = $this->flip_axes ? $this->label_y : $this->label_x;
    $lv = $this->flip_axes ? $this->label_x : $this->label_y;
    if(empty($this->label_h) && !empty($lh)) {
      // cope with multiple Y axis labels on horizontal graph
      $this->label_h = is_array($lh) ? array_shift($lh) : $lh;
    }
    if(empty($this->label_v) && !empty($lv))
      $this->label_v = $lv;

    $right_labels = array();
    $svg_text = new SVGGraphText($this);
    if(!empty($this->label_v)) {
      $lines_left = 0;
      $lines_right = array();
      if(is_array($this->label_v) && $this->YAxisCount() > 1) {

        foreach($this->label_v as $axis_no => $label_text) {
          if(is_null($label_text) || $axis_no > $this->YAxisCount() - 1)
            continue;
          $count = $svg_text->Lines($label_text);
          if($axis_no == 0)
            $lines_left = $count;
          else
            $lines_right[$axis_no] = $count;
        }
      } else {

        $label = is_array($this->label_v) ? $this->label_v[0] : $this->label_v;
        // increase padding
        if($this->axis_right) {
          $this->label_v = array(1 => $label);
          $lines_right[1] = $svg_text->Lines($label);
        } else {
          $this->label_v = $label;
          $lines_left = $svg_text->Lines($label);
        }
      }

      if(!empty($lines_right)) {
        foreach($lines_right as $axis_no => $num_lines) {
          $font_size = $this->GetFirst(
            $this->ArrayOption($this->label_font_size_v, $axis_no),
            $this->label_font_size);

          // store width and text offset, fix position later
          $label_width = $num_lines * $font_size + 2 * $this->label_space;
          if(is_null($grid_r))
            $this->pad_right += $label_width;
          $right_labels[$axis_no] = array($label_width,
            - ($font_size + $this->label_space));
        }
      }
      if($lines_left) {
        $font_size = $this->GetFirst(
          $this->ArrayOption($this->label_font_size_v, 0),
          $this->label_font_size);
        if(is_null($grid_l)) {
          $this->label_left_offset = $this->pad_left + $this->label_space +
            $font_size;
          $this->pad_left += $lines_left * $font_size + 2 * $this->label_space;
        } else {
          $this->label_left_offset = $this->label_space + $font_size;
        }
      }
    }
    if(!empty($this->label_h)) {
      $lines = $svg_text->Lines($this->label_h);
      $font_size = $this->GetFirst($this->label_font_size_h,
        $this->label_font_size);
      if(is_null($grid_b)) {
        $this->label_bottom_offset = $this->pad_bottom + $this->label_space +
          $font_size * ($lines - 1);
        $this->pad_bottom += $lines * $font_size + 2 * $this->label_space;
      } else {
        $this->label_bottom_offset = $this->label_space +
          $font_size * ($lines - 1);
      }
    }
    $pad_l = $pad_r = $pad_b = $pad_t = 0;
    $space_x = $this->width - $this->pad_left - $this->pad_right;
    $space_y = $this->height - $this->pad_top - $this->pad_bottom;
    if($this->show_axes) {

      $ends = $this->GetAxisEnds();

      if($this->show_axis_text_v || $this->show_axis_text_h) {
        $extra_r = $extra_t = 0;

        for($i = 0; $i < 10; ++$i) {
          // find the text bounding box and add overlap to padding
          // repeat with the new measurements in case overlap increases
          $x_len = $space_x - $pad_r - $pad_l;
          $y_len = $space_y - $pad_t - $pad_b;

          // 3D graphs will use this to reduce axis length
          list($extra_r, $extra_t) = $this->AdjustAxes($x_len, $y_len);

          list($x_axes, $y_axes) = $this->GetAxes($ends, $x_len, $y_len);
          $bbox = $this->FindAxisTextBBox($x_len, $y_len, $x_axes, $y_axes);
          $pr = $pl = $pb = $pt = 0;

          if($bbox['max_x'] > $x_len)
            $pr = ceil($bbox['max_x'] - $x_len);
          if($bbox['min_x'] < 0)
            $pl = ceil(abs($bbox['min_x']));
          if($bbox['min_y'] < 0)
            $pt = ceil(abs($bbox['min_y']));
          if($bbox['max_y'] > $y_len)
            $pb = ceil($bbox['max_y'] - $y_len);

          if($pr == $pad_r && $pl == $pad_l && $pt == $pad_t && $pb == $pad_b)
            break;
          $pad_r = $pr;
          $pad_l = $pl;
          $pad_t = $pt;
          $pad_b = $pb;
        }

        $div_size = $this->DivisionOverlap($x_axes, $y_axes);
        $pad_r = max($pad_r, $div_size['r']);
        $pad_l = max($pad_l, $div_size['l']);
        $pad_b = max($pad_b, $div_size['b']);
        $pad_t = max($pad_t, $div_size['t']);
        $pad_r += $extra_r;
        $pad_t += $extra_t;
      } else {

        // make space for divisions
        list($x_axes, $y_axes) = $this->GetAxes($ends, $space_x, $space_y);
        $div_size = $this->DivisionOverlap($x_axes, $y_axes);
        $pad_b = $div_size['b'];
        $pad_r = $div_size['r'];
        $pad_l = $div_size['l'];
        $pad_t = $div_size['t'];

        // extra axes means extra space
        if(count($y_axes) > 1) {
          $first = count($y_axes) - 1;
          $right_axis = $this->width - $this->pad_right;
          for($axis_no = $first; $axis_no > 0; --$axis_no) {
            $axis = $y_axes[$axis_no];

            $ybb = $this->YAxisBBox($axis, $space_y, $axis_no, false,
              $this->show_axis_v);
            $axis_width = $this->axis_space + $ybb['max_x'] - $ybb['min_x'];
            if($axis_no > 1) {
              $this->y_axis_positions[$axis_no] = $right_axis - $ybb['max_x'];
              $pad_r += $axis_width;
            } else {
              $this->y_axis_positions[$axis_no] = $right_axis;
            }
            $right_axis -= $axis_width;
          }
        }
      }
    } else {
      // 3D graphs will use this to reduce axis length
      list($pad_r, $pad_t) = $this->AdjustAxes($space_x, $space_y);
    }
    // apply the extra padding
    if(is_null($grid_l))
      $this->pad_left += $pad_l;
    if(is_null($grid_b))
      $this->pad_bottom += $pad_b;
    if(is_null($grid_r))
      $this->pad_right += $pad_r;
    if(is_null($grid_t))
      $this->pad_top += $pad_t;

    if(!is_null($grid_r) || !is_null($grid_l)) {
      // fixed grid position means recalculating axis positions
      $offset = 0;
      foreach($this->y_axis_positions as $axis_no => $pos) {
        if($axis_no == 0)
          continue;
        if($offset) {
          $newpos = $pos + $offset;
        } else {
          $newpos = $this->width - $this->pad_left - $this->pad_right;
          $offset = $newpos - $pos;
        }
        $this->y_axis_positions[$axis_no] = $newpos;
      }
    }

    // axis labels need to be readjusted along with axes
    $total_label_space = 0;
    foreach($this->y_axis_positions as $axis_no => $pos) {
      $pos = $this->y_axis_positions[$axis_no] += $total_label_space;
      if($axis_no > 0 && $pos <= 0)
        throw new Exception('Not enough space for ' . $this->YAxisCount() . ' axes');
      if(isset($right_labels[$axis_no])) {
        list($width, $offset) = $right_labels[$axis_no];
        $ybb = $this->YAxisBBox($y_axes[$axis_no], $space_y, $axis_no,
          $this->show_axis_text_v, $this->show_axis_v);
        $this->label_right_position[$axis_no] = $this->pad_left + $pos +
          $ybb['max_x'] + $width + $offset;
        $total_label_space += $width;
      }
    }
    $this->label_adjust_done = true;
  }

  /**
   * Subclasses can override this to modify axis lengths
   * Return amount of padding added [r,t]
   */
  protected function AdjustAxes(&$x_len, &$y_len)
  {
    return array(0, 0);
  }

  /**
   * Find the bounding box of the axis text for given axis lengths
   */
  protected function FindAxisTextBBox($length_x, $length_y, $x_axes, $y_axes)
  {
    // initialise maxima and minima
    $min_x = $this->width;
    $min_y = $this->height;
    $max_x = $max_y = 0;

    // need actual text positions
    $div_size = $this->DivisionOverlap($x_axes, $y_axes);
    $inside_x = ('inside' == $this->GetFirst($this->axis_text_position_h,
      $this->axis_text_position));
    $font_size = $this->axis_font_size;

    // if outside, use the division overlap as starting positions
    $min_x = - $div_size['l'];
    $max_y = $length_y + $div_size['b'];

    // only do this if there is x-axis text
    if($this->show_axis_text_h) {
      $x_axis = $x_axes[0];
      $offset = 0;
      if($this->label_centre && !$this->flip_axes) {
        $x_axis->Bar();
        $offset = 0.5 * $x_axis->Unit();
      }
      $points = $x_axis->GetGridPoints(0);
      $positions = $this->XAxisTextPositions($points, $offset,
        $div_size['b'], $this->axis_text_angle_h, $inside_x);
      foreach($positions as $p) {
        switch($p['text-anchor']) {
        case 'middle' : $off_x = $p['w'] / 2; break;
        case 'end' : $off_x = $p['w']; break;
        default : $off_x = 0;
        }
        $x = $p['x'] - $off_x;
        $y = $p['y'] - $font_size + $length_y;
        $xw = $x + $p['w'];
        $yh = $y + $p['h'];

        if($x < $min_x)
          $min_x = $x;
        if($xw > $max_x)
          $max_x = $xw;
        if($y < $min_y)
          $min_y = $y;
        if($yh > $max_y)
          $max_y = $yh;
      }
    }
    if($this->show_axis_v || $this->show_axis_text_v) {
      $axis_no = -1;
      $right_pos = $length_x;
      $space = $this->axis_space;
      foreach($y_axes as $y_axis) {
        ++$axis_no;
        if(is_null($y_axis))
          continue;
        $ybb = $this->YAxisBBox($y_axis, $length_y, $axis_no,
          $this->show_axis_text_v, $this->show_axis_v);

        if($axis_no > 0) {
          // for offset axes, the inside overlap must be added on too
          $outer = $ybb['max_x'];
          $inner = $axis_no > 1 ? abs($ybb['min_x']) : 0;

          $this->y_axis_positions[$axis_no] = $right_pos + $inner;
          $ybb['max_x'] += $right_pos + $inner;
          $ybb['min_x'] += $right_pos + $inner;
          $right_pos += $inner + $outer + $space;
        } else {
          $this->y_axis_positions[$axis_no] = 0;
        }

        if($ybb['max_x'] > $max_x)
          $max_x = $ybb['max_x'];
        if($ybb['min_x'] < $min_x)
          $min_x = $ybb['min_x'];
        if($ybb['max_y'] > $max_y)
          $max_y = $ybb['max_y'];
        if($ybb['min_y'] < $min_y)
          $min_y = $ybb['min_y'];
      }
    }
    return compact('min_x', 'min_y', 'max_x', 'max_y');
  }

  /**
   * Returns bounding box for a Y-axis
   */
  protected function YAxisBBox($axis, $length, $axis_no, $show_text, $show_axis)
  {
    $min_x = $max_x = $min_y = 0;
    $max_y = $length;
    $right = ($axis_no > 0);

    // get size of divisions and subdivisions
    $div_size = $inner_size = 0;
    if($show_axis && $this->show_divisions) {
      $dstyle = $this->GetFirst(
        $this->ArrayOption($this->division_style_v, $axis_no),
        $this->division_style);
      $dsize = $this->GetFirst(
        $this->ArrayOption($this->division_size_v, $axis_no),
        $this->division_size);
      $div_size = $this->DOverlap($dstyle, $dsize);
      if($this->show_subdivisions) {
        $sdstyle = $this->GetFirst(
          $this->ArrayOption($this->subdivision_style_v, $axis_no),
          $this->subdivision_style);
        $sdsize = $this->GetFirst(
          $this->ArrayOption($this->subdivision_size_v, $axis_no),
          $this->subdivision_size);
        $subdiv_size = $this->DOverlap($sdstyle, $sdsize);
        $div_size = max($div_size, $subdiv_size);
      }

      if($axis_no > 1) {
        // get inner size of divisions/subdivisions
        $inner_size = $this->DOverlap($dstyle, $dsize, true);
        if($this->show_subdivisions) {
          $inner_sdsize = $this->DOverlap($sdstyle, $sdsize, true);
          $inner_size = max($inner_size, $inner_sdsize);
        }
        if($inner_size > 0)
          $min_x = -$inner_size;
      }
      $max_x = $div_size;
    }

    if($show_text) {
      $inside = ('inside' == $this->GetFirst(
        $this->ArrayOption($this->axis_text_position_v, $axis_no),
        $this->axis_text_position));
      $offset = 0;
      if($this->label_centre && $this->flip_axes) {
        $axis->Bar();
        $offset = -0.5 * $axis->Unit();
      }

      $points = $axis->GetGridPoints(0);
      $positions = $this->YAxisTextPositions($points,
        $div_size,
        $offset, $this->ArrayOption($this->axis_text_angle_v, $axis_no),
        $inside xor $right, $axis_no);

      $font_size = $this->GetFirst(
        $this->ArrayOption($this->axis_font_size_v, $axis_no),
        $this->axis_font_size);
      foreach($positions as $p) {
        $x = $p['x'] - ($p['text-anchor'] == 'end' ? $p['w'] : 0);
        $y = $p['y'] - $font_size + $length;
        $xw = $x + $p['w'];
        $yh = $y + $p['h'];

        if($x < $min_x)
          $min_x = $x;
        if($xw > $max_x)
          $max_x = $xw;
        if($y < $min_y)
          $min_y = $y;
        if($yh > $max_y)
          $max_y = $yh;
      }
    }

    return compact('min_x', 'min_y', 'max_x', 'max_y');
  }

  /**
   * Returns the amount of overlap the divisions and subdivisions use
   */
  protected function DivisionOverlap($x_axes, $y_axes)
  {
    $l = $r = $t = $b = 0;
    if($this->show_divisions || $this->show_subdivisions) {

      $x_count = count($x_axes);
      $y_count = count($y_axes);
      for($i = 0; $i < $x_count; ++$i) {
        if(is_null($x_axes[$i]))
          continue;
        $x = $this->DOverlap(
          $this->GetFirst($this->ArrayOption($this->division_style_h, $i),
            $this->division_style),
          $this->GetFirst($this->ArrayOption($this->division_size_h, $i), 
            $this->division_size));
        if($this->show_subdivisions) {
          $sx = $this->DOverlap(
            $this->GetFirst($this->ArrayOption($this->subdivision_style_h, $i),
              $this->subdivision_style),
            $this->GetFirst($this->ArrayOption($this->subdivision_size_h, $i),
            $this->subdivision_size));
          $x = max($x, $sx);
        }
        if($i > 0)
          $t = $x;
        else
          $b = $x;
      }

      if($this->show_axis_v) {
        for($i = 0; $i < $y_count; ++$i) {
          if(is_null($y_axes[$i]))
            continue;
          $y = $this->DOverlap(
            $this->GetFirst($this->ArrayOption($this->division_style_v, $i),
              $this->division_style),
            $this->GetFirst($this->ArrayOption($this->division_size_v, $i),
              $this->division_size));
          if($this->show_subdivisions) {
            $sy = $this->DOverlap(
              $this->GetFirst($this->ArrayOption($this->subdivision_style_v, $i),
                $this->subdivision_style),
              $this->GetFirst($this->ArrayOption($this->subdivision_size_v, $i),
                $this->subdivision_size));
            $y = max($y, $sy);
          }
          if($i > 0)
            $r = $y;
          else
            $l = $y;
        }
      }
    }
    return compact('l', 'r', 't', 'b');
  }

  /**
   * Calculates the overlap of a division or subdivision
   * Set $inner for inside overlap
   */
  protected function DOverlap($style, $size, $inner = false)
  {
    $overlap = 0;
    switch($style) {
    case 'none' :
      return 0;
    case 'in' :
    case 'infull' :
      return $inner ? $size : 0;
    case 'over' :
    case 'overfull' :
      return $size;
    case 'out' :
    default :
      return $inner ? 0 : $size;
    }
  }

  /**
   * Sets up grid width and height to fill padded area
   */
  protected function SetGridDimensions()
  {
    $this->g_height = $this->height - $this->pad_top - $this->pad_bottom;
    $this->g_width = $this->width - $this->pad_left - $this->pad_right;
  }

  /**
   * Returns the number of Y-axes
   */
  protected function YAxisCount()
  {
    if($this->single_axis || empty($this->dataset_axis) ||
      empty($this->multi_graph) || !is_array($this->dataset_axis) ||
      count($this->multi_graph) < 2)
      return 1;
    $y_axes = array();
    $dataset_count = count($this->multi_graph);
    foreach($this->dataset_axis as $dataset => $axis) {

      // skip trailing empty datasets
      if($this->multi_graph->GetValues()->ItemsCount($dataset) < 1)
        continue;

      // finished assigning axes?
      if($dataset >= $dataset_count)
        break;
      $y_axes[] = $axis;
    }
    return count(array_unique($y_axes));
  }

  /**
   * Returns the number of X-axes
   */
  protected function XAxisCount()
  {
    return 1;
  }

  /**
   * Returns an x or y axis, or NULL if it does not exist
   */
  public function GetAxis($axis, $num)
  {
    if(is_null($num))
      $num = ($axis == 'y' ? $this->main_y_axis : $this->main_x_axis);
    $axis_var = $axis == 'y' ? 'y_axes' : 'x_axes';
    if(isset($this->{$axis_var}) && isset($this->{$axis_var}[$num]))
      return $this->{$axis_var}[$num];
    return NULL;
  }

  /**
   * Returns the Y-axis for a dataset
   */
  protected function DatasetYAxis($dataset)
  {
    if(!empty($this->dataset_axis) && isset($this->dataset_axis[$dataset]))
      return $this->dataset_axis[$dataset];
    return $this->axis_right ? 1 : 0;
  }

  /**
   * Returns the minimum key value for an axis
   */
  protected function GetAxisMinKey($axis)
  {
    return $this->GetMinKey();
  }
  protected function GetAxisMaxKey($axis)
  {
    return $this->GetMaxKey();
  }

  /**
   * Returns the minimum value for an axis
   */
  protected function GetAxisMinValue($axis)
  {
    if($this->single_axis || empty($this->dataset_axis) || 
      empty($this->multi_graph))
      return $this->GetMinValue();

    $min = array();
    $datasets = count($this->values);
    for($i = 0; $i < $datasets; ++$i) {
      if($this->DatasetYAxis($i) == $axis)
        $min[] = $this->values->GetMinValue($i);
    }
    return empty($min) ? NULL : min($min);
  }

  /**
   * Returns the maximum value for an axis
   */
  protected function GetAxisMaxValue($axis)
  {
    if($this->single_axis || empty($this->dataset_axis) ||
      empty($this->multi_graph))
      return $this->GetMaxValue();

    $max = array();
    $datasets = count($this->values);
    for($i = 0; $i < $datasets; ++$i) {
      if($this->DatasetYAxis($i) == $axis)
        $max[] = $this->values->GetMaxValue($i);
    }
    return empty($max) ? NULL : max($max);
  }

  /**
   * Returns an array containing the value and key axis min and max
   */
  protected function GetAxisEnds()
  {
    // check guides
    if(is_null($this->guidelines))
      $this->CalcGuidelines();

    $v_max = $v_min = $k_max = $k_min = array();
    $g_min_x = $g_min_y = $g_max_x = $g_max_y = NULL;

    if(!is_null($this->guidelines)) {
      list($g_min_x, $g_min_y, $g_max_x, $g_max_y) = $this->guidelines->GetMinMax();
    }
    $y_axis_count = $this->YAxisCount();
    $x_axis_count = $this->XAxisCount();
    if($this->flip_axes) {
      $x_min_fixed = $this->axis_min_v;
      $x_max_fixed = $this->axis_max_v;
      $y_min_fixed = $this->axis_min_h;
      $y_max_fixed = $this->axis_max_h;
    } else {
      $y_min_fixed = $this->axis_min_v;
      $y_max_fixed = $this->axis_max_v;
      $x_min_fixed = $this->axis_min_h;
      $x_max_fixed = $this->axis_max_h;
    }

    for($i = 0; $i < $y_axis_count; ++$i) {
      $fixed_max = $this->ArrayOption($y_max_fixed, $i);
      $fixed_min = $this->ArrayOption($y_min_fixed, $i);

      // validate
      if(is_numeric($fixed_min) && is_numeric($fixed_max) &&
        $fixed_max < $fixed_min)
        throw new Exception("Invalid Y axis options: min > max ({$fixed_min} > {$fixed_max})");

      if(is_numeric($fixed_min)) {
        $v_min[] = $fixed_min;
      } else {
        $minv_list = array($this->GetAxisMinValue($i));
        if(!is_null($g_min_y))
          $minv_list[] = (float)$g_min_y;

        // if not a log axis, start at 0
        if(!$this->ArrayOption($this->log_axis_y, $i))
          $minv_list[] = 0;
        $v_min[] = min($minv_list);
      }

      if(is_numeric($fixed_max)) {
        $v_max[] = $fixed_max;
      } else {
        $maxv_list = array($this->GetAxisMaxValue($i));
        if(!is_null($g_max_y))
          $maxv_list[] = (float)$g_max_y;

        // if not a log axis, start at 0
        if(!$this->ArrayOption($this->log_axis_y, $i))
          $maxv_list[] = 0;
        $v_max[] = max($maxv_list);
      }
      if($v_max[$i] < $v_min[$i])
        throw new Exception("Invalid Y axis: min > max ({$v_min[$i]} > {$v_max[$i]})");
    }

    for($i = 0; $i < $x_axis_count; ++$i) {
      $fixed_max = $this->ArrayOption($x_max_fixed, $i);
      $fixed_min = $this->ArrayOption($x_min_fixed, $i);

      if($this->datetime_keys) {
        // 0 is 1970-01-01, not a useful minimum
        if(empty($fixed_max)) {
          // guidelines support datetime values too
          if(!is_null($g_max_x))
            $k_max[] = max($this->GetAxisMaxKey($i), $g_max_x);
          else
            $k_max[] = $this->GetAxisMaxKey($i);
        } else {
          $d = SVGGraphDateConvert($fixed_max);
          // subtract a se
          if(!is_null($d))
            $k_max[] = $d - 1;
          else
            throw new Exception("Could not convert [{$fixed_max}] to datetime");
        }
        if(empty($fixed_min)) {
          if(!is_null($g_min_x))
            $k_min[] = min($this->GetAxisMinKey($i), $g_min_x);
          else
            $k_min[] = $this->GetAxisMinKey($i);
        } else {
          $d = SVGGraphDateConvert($fixed_min);
          if(!is_null($d))
            $k_min[] = $d;
          else
            throw new Exception("Could not convert [{$fixed_min}] to datetime");
        }
      } else {
        // validate
        if(is_numeric($fixed_min) && is_numeric($fixed_max) &&
          $fixed_max < $fixed_min)
          throw new Exception("Invalid X axis options: min > max ({$fixed_min} > {$fixed_max})");

        if(is_numeric($fixed_max))
          $k_max[] = $fixed_max;
        else
          $k_max[] = max(0, $this->GetAxisMaxKey($i), (float)$g_max_x);
        if(is_numeric($fixed_min))
          $k_min[] = $fixed_min;
        else
          $k_min[] = min(0, $this->GetAxisMinKey($i), (float)$g_min_x);
      }
      if($k_max[$i] < $k_min[$i])
        throw new Exception("Invalid X axis: min > max ({$k_min[$i]} > {$k_max[$i]})");
    }
    return compact('v_max', 'v_min', 'k_max', 'k_min');
  }

  /**
   * Returns the X and Y axis class instances as a list
   */
  protected function GetAxes($ends, &$x_len, &$y_len)
  {
    // disable units for associative keys
    if($this->values->AssociativeKeys())
      $this->units_x = $this->units_before_x = null;

    $x_axes = array();
    $x_axis_count = $this->XAxisCount();
    for($i = 0; $i < $x_axis_count; ++$i) {

      $x_min_space = $this->GetFirst(
        $this->ArrayOption($this->minimum_grid_spacing_h, $i),
        $this->minimum_grid_spacing);
      $grid_division = $this->ArrayOption($this->grid_division_h, $i);
      if(is_numeric($grid_division)) {
        if($grid_division <= 0)
          throw new Exception('Invalid grid division');
        // if fixed grid spacing is specified, make the min spacing 1 pixel
        $this->minimum_grid_spacing_h = $x_min_space = 1;
      }

      if($this->flip_axes) {
        $max_h = $ends['v_max'][$i];
        $min_h = $ends['v_min'][$i];
        $x_min_unit = $this->ArrayOption($this->minimum_units_y, $i);
        $x_fit = false;
        $x_units_after = (string)$this->ArrayOption($this->units_y, $i);
        $x_units_before = (string)$this->ArrayOption($this->units_before_y, $i);
        $x_decimal_digits = $this->GetFirst(
          $this->ArrayOption($this->decimal_digits_y, $i),
          $this->decimal_digits);
        $x_text_callback = $this->GetFirst(
          $this->ArrayOption($this->axis_text_callback_y, $i),
          $this->axis_text_callback);
        $x_values = false;
      } else {
        $max_h = $ends['k_max'][$i];
        $min_h = $ends['k_min'][$i];
        $x_min_unit = 1;
        $x_fit = true;
        $x_units_after = (string)$this->ArrayOption($this->units_x, $i);
        $x_units_before = (string)$this->ArrayOption($this->units_before_x, $i);
        $x_decimal_digits = $this->GetFirst(
          $this->ArrayOption($this->decimal_digits_x, $i),
          $this->decimal_digits);
        $x_text_callback = $this->GetFirst(
          $this->ArrayOption($this->axis_text_callback_x, $i),
          $this->axis_text_callback);
        $x_values = $this->multi_graph ? $this->multi_graph : $this->values;
      }

      if(!is_numeric($max_h) || !is_numeric($min_h))
        throw new Exception('Non-numeric min/max');

      if($this->datetime_keys && !$this->flip_axes) {
        require_once 'SVGGraphAxisDateTime.php';
        $x_axis = new AxisDateTime($x_len, $max_h, $min_h, $x_min_space,
          $grid_division, $this->settings);
      } elseif($this->ArrayOption($this->log_axis_y, $i) && $this->flip_axes) {
        require_once 'SVGGraphAxisLog.php';
        $x_axis = new AxisLog($x_len, $max_h, $min_h, $x_min_unit, $x_min_space,
          $x_fit, $x_units_before, $x_units_after, $x_decimal_digits,
          $this->ArrayOption($this->log_axis_y_base, $i),
          $grid_division, $x_text_callback);
      } elseif(!is_numeric($grid_division)) {
        $x_axis = new Axis($x_len, $max_h, $min_h, $x_min_unit, $x_min_space,
          $x_fit, $x_units_before, $x_units_after, $x_decimal_digits,
          $x_text_callback, $x_values);
      } else {
        require_once 'SVGGraphAxisFixed.php';
        $x_axis = new AxisFixed($x_len, $max_h, $min_h, $grid_division,
          $x_units_before, $x_units_after, $x_decimal_digits, $x_text_callback,
          $x_values);
      }
      $x_axes[] = $x_axis;
    }

    $y_axes = array();
    $y_axis_count = $this->YAxisCount();
    for($i = 0; $i < $y_axis_count; ++$i) {

      $y_min_space = $this->GetFirst(
        $this->ArrayOption($this->minimum_grid_spacing_v, $i),
        $this->minimum_grid_spacing);
      // make sure minimum_grid_spacing option array
      if(!is_array($this->minimum_grid_spacing_v))
        $this->minimum_grid_spacing_v = array();

      $grid_division = $this->ArrayOption($this->grid_division_v, $i);
      if(is_numeric($grid_division)) {
        if($grid_division <= 0)
          throw new Exception('Invalid grid division');
        // if fixed grid spacing is specified, make the min spacing 1 pixel
        $this->minimum_grid_spacing_v[$i] = $y_min_space = 1;
      } elseif(!isset($this->minimum_grid_spacing_v[$i])) {
        $this->minimum_grid_spacing_v[$i] = $y_min_space;
      }

      if($this->flip_axes) {
        $max_v = $ends['k_max'][$i];
        $min_v = $ends['k_min'][$i];
        $y_min_unit = 1;
        $y_fit = true;
        $y_units_after = (string)$this->ArrayOption($this->units_x, $i);
        $y_units_before = (string)$this->ArrayOption($this->units_before_x, $i);
        $y_decimal_digits = $this->GetFirst(
          $this->ArrayOption($this->decimal_digits_x, $i),
          $this->decimal_digits);
        $y_text_callback = $this->GetFirst(
          $this->ArrayOption($this->axis_text_callback_x, $i),
          $this->axis_text_callback);
        $y_values = $this->multi_graph ? $this->multi_graph : $this->values;
      } else {
        $max_v = $ends['v_max'][$i];
        $min_v = $ends['v_min'][$i];
        $y_min_unit = $this->ArrayOption($this->minimum_units_y, $i);
        $y_fit = false;
        $y_units_after = (string)$this->ArrayOption($this->units_y, $i);
        $y_units_before = (string)$this->ArrayOption($this->units_before_y, $i);
        $y_decimal_digits = $this->GetFirst(
          $this->ArrayOption($this->decimal_digits_y, $i),
          $this->decimal_digits);
        $y_text_callback = $this->GetFirst(
          $this->ArrayOption($this->axis_text_callback_y, $i),
          $this->axis_text_callback);
        $y_values = false;
      }

      if(!is_numeric($max_v) || !is_numeric($min_v))
        throw new Exception('Non-numeric min/max');

      if($this->datetime_keys && $this->flip_axes) {
        require_once 'SVGGraphAxisDateTime.php';
        $y_axis = new AxisDateTime($y_len, $max_v, $min_v, $y_min_space,
          $grid_division, $this->settings);
      } elseif($this->ArrayOption($this->log_axis_y, $i) && !$this->flip_axes) {
        require_once 'SVGGraphAxisLog.php';
        $y_axis = new AxisLog($y_len, $max_v, $min_v, $y_min_unit, $y_min_space,
          $y_fit, $y_units_before, $y_units_after, $y_decimal_digits,
          $this->ArrayOption($this->log_axis_y_base, $i),
          $grid_division, $y_text_callback);
      } elseif(!is_numeric($grid_division)) {
        $y_axis = new Axis($y_len, $max_v, $min_v, $y_min_unit, $y_min_space,
          $y_fit, $y_units_before, $y_units_after, $y_decimal_digits,
          $y_text_callback, $y_values);
      } else {
        require_once 'SVGGraphAxisFixed.php';
        $y_axis = new AxisFixed($y_len, $max_v, $min_v, $grid_division,
          $y_units_before, $y_units_after, $y_decimal_digits, $y_text_callback,
          $y_values);
      }

      $y_axis->Reverse(); // because axis starts at bottom

      $y_axes[] = $y_axis;
    }

    // set the main axis correctly
    if($this->axis_right && count($y_axes) == 1) {
      $this->main_y_axis = 1;
      array_unshift($y_axes, NULL);
    }
    return array($x_axes, $y_axes);
  }

  /**
   * Calculates the effect of axes, applying to padding
   */
  protected function CalcAxes()
  {
    if($this->axes_calc_done)
      return;

    // can't have multiple invisible axes
    if(!$this->show_axes)
      $this->dataset_axis = NULL;

    $ends = $this->GetAxisEnds();
    if(!$this->label_adjust_done)
      $this->LabelAdjustment();
    if(is_null($this->g_height) || is_null($this->g_width))
      $this->SetGridDimensions();

    list($x_axes, $y_axes) = $this->GetAxes($ends, $this->g_width,
      $this->g_height);

    $main_axes = $this->flip_axes ? $y_axes : $x_axes;
    if($this->label_centre)
      foreach($main_axes as $axis)
        if(!is_null($axis))
          $axis->Bar();

    $this->x_axes = $x_axes;
    $this->y_axes = $y_axes;

    $this->axes_calc_done = true;
  }

  /**
   * Calculates the position of grid lines
   */
  protected function CalcGrid()
  {
    if(isset($this->grid_calc_done))
      return;

    $grid_bottom = $this->height - $this->pad_bottom;
    $grid_left = $this->pad_left;

    $y_axis = $this->y_axes[$this->main_y_axis];
    $x_axis = $this->x_axes[$this->main_x_axis];
    $y_points = $y_axis->GetGridPoints($grid_bottom);
    $x_points = $x_axis->GetGridPoints($grid_left);

    if($this->flip_axes) {
      $this->grid_limit = $this->label_centre ?
        $this->g_height - ($y_axis->Unit() / 2) : $this->g_height;
    } else {
      $this->grid_limit = $this->label_centre ?
        $this->g_width - ($x_axis->Unit() / 2) : $this->g_width;
    }
    $this->grid_limit += 0.01; // allow for floating-point inaccuracy
    $this->grid_calc_done = true;
  }

  /**
   * Returns the grid points for a Y-axis
   */
  protected function GetGridPointsY($axis)
  {
    return $this->y_axes[$axis]->GetGridPoints($this->height - $this->pad_bottom);
  }

  /**
   * Returns the grid points for an X-axis
   */
  protected function GetGridPointsX($axis)
  {
    return $this->x_axes[$axis]->GetGridPoints($this->pad_left);
  }

  /**
   * Returns the subdivisions for a Y-axis
   */
  protected function GetSubDivsY($axis)
  {
    return $this->y_axes[$axis]->GetGridSubdivisions(
      $this->minimum_subdivision,
      $this->flip_axes ? 1 : $this->ArrayOption($this->minimum_units_y, $axis),
      $this->height - $this->pad_bottom, 
      $this->ArrayOption($this->subdivision_v, $axis));
  }

  /**
   * Returns the subdivisions for an X-axis
   */
  protected function GetSubDivsX($axis)
  {
    return $this->x_axes[$axis]->GetGridSubdivisions(
      $this->minimum_subdivision,
      $this->flip_axes ? $this->ArrayOption($this->minimum_units_y, $axis) : 1,
      $this->pad_left,
      $this->ArrayOption($this->subdivision_h, $axis));
  }

  /**
   * Returns the X axis SVG fragment
   */
  protected function XAxis($yoff)
  {
    $x = $this->pad_left - $this->axis_overlap;
    $y = $this->height - $this->pad_bottom - $yoff;
    $len = $this->g_width + 2 * $this->axis_overlap;
    $path = array('d' => "M$x {$y}h$len");
    if(!empty($this->axis_colour_h))
      $path['stroke'] = $this->axis_colour_h;
    if(!empty($this->axis_stroke_width_h))
      $path['stroke-width'] = $this->axis_stroke_width_h;
    return $this->Element('path', $path);
  }

  /**
   * Returns the Y axis SVG fragment
   */
  protected function YAxis($i)
  {
    if($i > 0) {
      $xoff = $this->y_axis_positions[$i];
    } else {
      $x0 = $this->x_axes[$this->main_x_axis]->Zero();
      $xoff = $x0 > 1 && $x0 < $this->g_width ? $x0 : 0;
    }
    $x = $this->pad_left + $xoff;
    $len = $this->g_height + 2 * $this->axis_overlap;
    $y = $this->height - $this->pad_bottom + $this->axis_overlap - $len;
    $path = array('d' => "M$x {$y}v$len");

    $colour = $this->ArrayOption($this->axis_colour_v, $i);
    $thickness = $this->ArrayOption($this->axis_stroke_width_v, $i);
    if(!empty($colour))
      $path['stroke'] = $colour;
    if(!empty($thickness))
      $path['stroke-width'] = $thickness;
    return $this->Element('path', $path);
  }

  /**
   * Returns the position and size of divisions
   * @retval array('pos' => $position, 'sz' => $size)
   */
  protected function DivisionsPositions($style, $size, $fullsize, $start,
    $axis_offset, $axis_opposite, $secondary_axis)
  {
    $sz = $size;
    $pos = $start + $axis_offset;
    if($secondary_axis)
      $style = str_replace('full', '', $style);

    switch($style) {
    case 'none' :
      return null; // no pos or sz
    case 'infull' :
      $pos = $start;
      $sz = $fullsize;
      break;
    case 'over' :
      $pos -= $size;
      $sz = $size * 2;
      break;
    case 'overfull' :
      $pos = $axis_opposite ? $start : $start - $size;
      $sz = $fullsize + $size;
      break;
    case 'in' :
      if($axis_opposite)
        $pos -= $size;
      break;
    case 'out' :
    default :
      if(!$axis_opposite)
        $pos -= $size;
      $sz = $size;
    }

    return array('sz' => $sz, 'pos' => $pos);
  }

  /**
   * Returns X-axis divisions as a path
   */
  protected function XAxisDivisions(&$points, $style, $size, $yoff)
  {
    $path = '';
    $pos = $this->DivisionsPositions($style, $size, $this->g_height,
      $this->pad_bottom, $yoff, false, false);
    if(is_null($pos))
      return '';

    $y = $this->height - $pos['pos'];
    $height = -$pos['sz'];
    foreach($points as $x)
      $path .= "M{$x->position} {$y}v{$height}";
    return $path;
  }

  /**
   * Returns Y-axis divisions as a path
   */
  protected function YAxisDivisions(&$points, $xoff, $subdiv, $axis_no)
  {
    $dz = 'division_size';
    $ds = 'division_style';
    $dzv = 'division_size_v';
    $dsv = 'division_style_v';
    if($subdiv) {
      $dz = 'subdivision_size';
      $ds = 'subdivision_style';
      $dzv = 'subdivision_size_v';
      $dsv = 'subdivision_style_v';
    }

    $style = $this->GetFirst($this->ArrayOption($this->{$dsv}, $axis_no), $this->{$ds});
    $size = $this->GetFirst($this->ArrayOption($this->{$dzv}, $axis_no), $this->{$dz});
    $path = '';
    $pos = $this->DivisionsPositions($style, $size, $this->g_width,
      $this->pad_left, $xoff, $axis_no > 0, $axis_no != $this->main_y_axis);
    if(is_null($pos))
      return '';

    $x = $pos['pos'];
    $size = $pos['sz'];
    foreach($points as $y) {
      $path .= "M$x {$y->position}h{$size}";
    }
    return $path;
  }

  /**
   * Returns the X-axis text positions
   */
  protected function XAxisTextPositions(&$points, $xoff, $yoff, $angle, $inside)
  {
    $positions = array();
    $x_prev = -$this->width;
    $count = count($points);
    $label_centre_x = $this->label_centre && !$this->flip_axes;
    $font = $this->GetFirst($this->axis_font_h, $this->axis_font);
    $font_size = $this->GetFirst($this->axis_font_size_h, $this->axis_font_size);
    $font_adjust = $this->GetFirst($this->axis_font_adjust_h, $this->axis_font_adjust);
    $text_space = $this->GetFirst($this->axis_text_space_h, $this->axis_text_space);
    $text_centre = $font_size * 0.3;

    if($inside)
    {
      $y = -$yoff - $text_space;
      $angle = -$angle;
      $x_rotate_offset = -$text_centre;
    }
    else
    {
      $y = $yoff + $font_size + $text_space - $text_centre;
      $x_rotate_offset = $text_centre;
    }
    if($angle < 0)
      $x_rotate_offset = -$x_rotate_offset;
    $y_rotate_offset = -$text_centre;
    $position = array('y' => $y);
    if($angle == 0) {
      $position['text-anchor'] = 'middle';
    } else {
      $position['text-anchor'] = $this->axis_text_angle_h < 0 ? 'end' : 'start';
    }
    $p = 0;
    $svg_text = new SVGGraphText($this, $font, $font_adjust);
    foreach($points as $grid_point) {
      $key = $grid_point->text;
      $x = $grid_point->position;

      // don't draw 0 over the axis line
      if($inside && !$label_centre_x && $key == '0')
        $key = '';

      if($svg_text->Strlen($key) > 0 && (++$p < $count || !$label_centre_x)) {
        $position['x'] = $x + $xoff;
        if($angle != 0) {
          $position['x'] -= $x_rotate_offset;
          $rcx = $position['x'] + $x_rotate_offset;
          $rcy = $position['y'] + $y_rotate_offset;
          $position['transform'] = "rotate($angle,$rcx,$rcy)";
        }
        $size = $svg_text->Measure((string)$key, $font_size, $angle, $font_size);
        $position['text'] = $key;
        $position['w'] = $size[0];
        $position['h'] = $size[1];
        $positions[] = $position;
      }
      $x_prev = $x;
    }
    return $positions;
  }

  /**
   * Returns the Y-axis text positions
   */
  protected function YAxisTextPositions(&$points, $xoff, $yoff, $angle, $inside, $axis_no)
  {
    $y_prev = $this->height;
    $font = $this->GetFirst(
      $this->ArrayOption($this->axis_font_v, $axis_no),
      $this->axis_font);
    $font_size = $this->GetFirst(
      $this->ArrayOption($this->axis_font_size_v, $axis_no),
      $this->axis_font_size);
    $font_adjust = $this->GetFirst(
      $this->ArrayOption($this->axis_font_adjust_v, $axis_no),
      $this->axis_font_adjust);
    $text_space = $this->GetFirst(
      $this->ArrayOption($this->axis_text_space_v, $axis_no),
      $this->axis_text_space);
    $label_centre_y = $this->label_centre && $this->flip_axes;
    $x = $xoff + $text_space;
    if(!$inside)
      $x = -$x;

    $position = array('x' => $x);
    $position['text-anchor'] = $inside ? 'start' : 'end';
    $positions = array();
    $count = count($points);
    $p = 0;
    $svg_text = new SVGGraphText($this, $font, $font_adjust);
    foreach($points as $grid_point) {
      $key = $grid_point->text;
      $y = $grid_point->position;

      // don't draw 0 over the axis line
      if($inside && !$label_centre_y && !$axis_no && $key == '0')
        $key = '';

      if($svg_text->Strlen($key) && (++$p < $count || !$label_centre_y)) {
        // get unrotated width and height first
        list($t_width, $t_height) = $svg_text->Measure($key, $font_size, 0,
          $font_size);
        $text_centre = $font_size * 0.8 - $t_height * 0.5;
        $position['y'] = $y + $text_centre + $yoff;

        if($angle != 0) {
          list($tr_width, $tr_height) = $svg_text->Measure($key, $font_size,
            $angle, $font_size);

          // axes of rotation are Y position and half height away from
          // start/end of text
          $rcx = $position['x'] + $t_height * ($inside ? 0.5 : -0.5);
          $rcy = $y + $yoff;
          $position['transform'] = compact('angle', 'rcx', 'rcy');
          $t_width = $tr_width;
          $t_height = $tr_height;
        }
        $position['text'] = $key;
        $position['w'] = $t_width;
        $position['h'] = $t_height;
        $positions[] = $position;
      }
      $y_prev = $y;
    }
    return $positions;
  }

  /**
   * Returns the X-axis text fragment
   */
  protected function XAxisText(&$points, $xoff, $yoff, $angle)
  {
    $inside = ('inside' == $this->GetFirst($this->axis_text_position_h,
      $this->axis_text_position));
    if($inside)
      $yoff -= $this->height - $this->pad_bottom;
    else
      $yoff += $this->height - $this->pad_bottom;
    $positions = $this->XAxisTextPositions($points, $xoff, $yoff, $angle,
      $inside);
    if(empty($positions))
      return '';

    $labels = '';
    $font = $this->GetFirst($this->axis_font_h, $this->axis_font);
    $font_size = $this->GetFirst($this->axis_font_size_h, $this->axis_font_size);
    $font_adjust = $this->GetFirst($this->axis_font_adjust_h,
      $this->axis_font_adjust);
    $anchor = $positions[0]['text-anchor'];
    $svg_text = new SVGGraphText($this, $font, $font_adjust);
    foreach($positions as $pos) {
      $text = $pos['text'];
      if($inside)
        $pos['y'] -= $pos['h'] - $font_size;
      unset($pos['w'], $pos['h'], $pos['text'], $pos['text-anchor']);
      $labels .= $svg_text->Text($text, $font_size, $pos);
    }
    $group = array('text-anchor' => $anchor);
    if(!empty($this->axis_font_h))
      $group['font-family'] = $this->axis_font_h;
    if(!empty($this->axis_font_size_h))
      $group['font-size'] = $font_size;
    if(!empty($this->axis_text_colour_h))
      $group['fill'] = $this->axis_text_colour_h;

    return $this->Element('g', $group, NULL, $labels);
  }

  /**
   * Returns the Y-axis text fragment
   */
  protected function YAxisText(&$points, $xoff, $yoff, $angle, $right, $axis_no)
  {
    $inside = ('inside' == $this->GetFirst(
      $this->ArrayOption($this->axis_text_position_v, $axis_no),
      $this->axis_text_position));
    if($inside xor $right)
      $xoff += $this->pad_left;
    else
      $xoff -= $this->pad_left;

    $positions = $this->YAxisTextPositions($points, $xoff, $yoff, $angle,
      $inside xor $right, $axis_no);
    if(empty($positions))
      return '';

    $labels = '';
    $font = $this->GetFirst(
      $this->ArrayOption($this->axis_font_v, $axis_no),
      $this->axis_font);
    $font_size = $this->GetFirst(
      $this->ArrayOption($this->axis_font_size_v, $axis_no),
      $this->axis_font_size);
    $font_adjust = $this->GetFirst(
      $this->ArrayOption($this->axis_font_adjust_v, $axis_no),
      $this->axis_font_adjust);
    $svg_text = new SVGGraphText($this, $font, $font_adjust);
    $anchor = $positions[0]['text-anchor'];
    foreach($positions as $pos) {
      $text = $pos['text'];
      if($right) {
        $pos['x'] += $this->y_axis_positions[$axis_no];
        if(isset($pos['transform']['rcx']))
          $pos['transform']['rcx'] += $this->y_axis_positions[$axis_no];
      }
      if(isset($pos['transform'])) {
        $t = $pos['transform'];
        $pos['transform'] = "rotate({$t['angle']},{$t['rcx']},{$t['rcy']})";
      }
      unset($pos['w'], $pos['h'], $pos['text'], $pos['text-anchor']);
      $labels .= $svg_text->Text($text, $font_size, $pos);
    }
    $group = array('text-anchor' => $anchor);
    if(!empty($this->axis_font_v))
      $group['font-family'] = $this->ArrayOption($this->axis_font_v, $axis_no);
    if(!empty($this->axis_font_size_v))
      $group['font-size'] = $font_size;
    if(!empty($this->axis_text_colour_v))
      $group['fill'] = $this->ArrayOption($this->axis_text_colour_v, $axis_no);

    return $this->Element('g', $group, NULL, $labels);
  }

  /**
   * Returns the horizontal axis label
   */
  protected function HLabel(&$attribs)
  {
    if(empty($this->label_h))
      return '';

    $x = ($this->width - $this->pad_left - $this->pad_right) / 2 +
      $this->pad_left;
    $y = $this->height - $this->label_bottom_offset;
    $pos = compact('x', 'y');
    $font = $this->GetFirst($this->label_font_h, $this->label_font);
    $svg_text = new SVGGraphText($this, $font);
    return $svg_text->Text($this->label_h, $this->label_font_size,
      array_merge($attribs, $pos));
  }

  /**
   * Returns the vertical axis label
   */
  protected function VLabel(&$attribs)
  {
    if(empty($this->label_v))
      return '';

    $y = ($this->height - $this->pad_bottom + $this->pad_top) / 2;

    $text = '';
    $label = is_array($this->label_v) ? $this->label_v : array($this->label_v);

    foreach($label as $i => $label_text) {
      if(is_null($label_text))
        continue;
      if($i > 0) {
        if(!isset($this->label_right_position[$i]))
          continue;
        $x = $this->label_right_position[$i];
        $transform = "rotate(90,$x,$y)";
      } else {
        $x = $this->label_left_offset;
        $transform = "rotate(270,$x,$y)";
      }
      $pos = compact('x', 'y', 'transform');
      $font = $this->GetFirst(
        $this->ArrayOption($this->label_font_v, $i),
        $this->label_font);
      $font_weight = $this->GetFirst(
        $this->ArrayOption($this->label_font_weight_v, $i),
        $this->label_font_weight);
      $font_size = $this->GetFirst(
        $this->ArrayOption($this->label_font_size_v, $i),
        $this->label_font_size,
        $this->ArrayOption($this->axis_font_v, $i),
        $this->axis_font);
      if($font != $this->axis_font)
        $pos['font-family'] = $font;
      if($font_weight != 'normal')
        $pos['font-weight'] = $font_weight;
      if($font_size != $this->axis_font_size)
        $pos['font-size'] = $font_size;
      $pos['fill'] = $this->GetFirst(
        $this->ArrayOption($this->label_colour_v, $i),
        $this->label_colour, 
        $this->ArrayOption($this->axis_text_colour_v, $i),
        $this->axis_text_colour);
      $svg_text = new SVGGraphText($this, $font);
      $text .= $svg_text->Text($label_text, $font_size, array_merge($attribs, $pos));
    }

    return $text;
  }

  /**
   * Returns the labels grouped with the provided axis division labels
   */
  protected function Labels($axis_text = '')
  {
    $labels = $axis_text;
    if(!empty($this->label_h) || !empty($this->label_v)) {
      $label_text = array('text-anchor' => 'middle');
      if($this->label_font != $this->axis_font)
        $label_text['font-family'] = $this->label_font;
      if($this->label_font_size != $this->axis_font_size)
        $label_text['font-size'] = $this->label_font_size;
      if($this->label_font_weight != 'normal')
        $label_text['font-weight'] = $this->label_font_weight;
      $label_text['fill'] = $this->GetFirst($this->label_colour_h,
        $this->label_colour, $this->axis_text_colour_h,
        $this->axis_text_colour);

      if(!empty($this->label_h)) {
        $label_text['y'] = $this->height - $this->label_bottom_offset;
        $label_text['x'] = $this->pad_left +
          ($this->width - $this->pad_left - $this->pad_right) / 2;
        $svg_text = new SVGGraphText($this, $this->label_font);
        $labels .= $svg_text->Text($this->label_h, $this->label_font_size,
          $label_text);
      }

      $labels .= $this->VLabel($label_text);
    }

    if(!empty($labels)) {
      $font = array(
        'font-size' => $this->axis_font_size,
        'font-family' => $this->axis_font,
        'fill' => $this->GetFirst($this->axis_text_colour, $this->axis_colour),
      );
      $labels = $this->Element('g', $font, NULL, $labels);
    }
    return $labels;
  }

  /**
   * Draws bar or line graph axes
   */
  protected function Axes()
  {
    if(!$this->show_axes)
      return $this->Labels();

    $this->CalcGrid();
    $main_y_axis = $this->y_axes[$this->main_y_axis];
    $main_x_axis = $this->x_axes[$this->main_x_axis];
    $y0 = $main_y_axis->Zero();
    $x0 = $main_x_axis->Zero();
    $x_axis_visible = $this->show_axis_h && $y0 >= 0 && $y0 <= $this->g_height;
    $y_axis_inside = $x0 >= 1 && $x0 < $this->g_width;
    $yoff = $x_axis_visible ? $y0 : 0;
    $xoff = $y_axis_inside ? $x0 : 0;
    $y_count = count($this->y_axes);

    $axis_group = $axes = $label_group = $divisions = $axis_text = '';
    if($this->show_axis_h)
      $axes .= $this->XAxis($yoff);
    if($this->show_axis_v) {
      for($i = 0; $i < $y_count; ++$i) {
        if(!is_null($this->y_axes[$i])) {
          $axes .= $this->YAxis($i);
        }
      }
    }

    if($axes != '') {
      $line = array();
      if(empty($this->axis_colour_h) || empty($this->axis_colour_v))
        $line['stroke'] = $this->axis_colour;
      if(empty($this->axis_stroke_width_h) || empty($this->axis_stroke_width_v))
        $line['stroke-width'] = $this->axis_stroke_width;
      $axis_group = empty($line) ? $axes : $this->Element('g', $line, NULL, $axes);
    }

    if($this->show_axis_text_v) {
      for($i = 0; $i < $y_count; ++$i) {
        $axis = $this->y_axes[$i];
        if(!is_null($axis)) {
          $offset = ($this->label_centre && $this->flip_axes ? -0.5 * $axis->Unit() : 0);
          $points = $this->GetGridPointsY($i);
          $text_offset = 0;
          if($this->show_axis_v && $this->show_divisions) {
            $text_offset = $this->DOverlap(
              $this->GetFirst($this->ArrayOption($this->division_style_v, $i),
                $this->division_style),
              $this->GetFirst($this->ArrayOption($this->division_size_v, $i),
                $this->division_size));
            if($this->show_subdivisions) {
              $text_offset_sd = $this->DOverlap(
                $this->GetFirst($this->ArrayOption($this->subdivision_style_v, $i),
                  $this->subdivision_style),
                $this->GetFirst($this->ArrayOption($this->subdivision_size_v, $i),
                $this->subdivision_size));
              $text_offset = max($text_offset, $text_offset_sd);
            }
          }
          $axis_text .= $this->YAxisText($points, $text_offset,
            $offset, $this->ArrayOption($this->axis_text_angle_v, $i),
            $i > 0, $i);
        }
      }
    }
    if($this->show_axis_text_h) {
      $text_offset = $this->DivisionOverlap($this->x_axes, $this->y_axes);
      $axis = $main_x_axis;
      $offset = ($this->label_centre && !$this->flip_axes ? 0.5 * $axis->Unit() : 0);
      $points = $this->GetGridPointsX(0);
      $axis_text .= $this->XAxisText($points, $offset,
        $text_offset['b'], $this->axis_text_angle_h);
    }

    $label_group = $this->Labels($axis_text);

    if($this->show_divisions) {
      // use an array to join paths with same colour
      $div_paths = array();
      if($this->show_axis_h) {
        $points = $this->GetGridPointsX(0);
        $dx_path = $this->XAxisDivisions($points,
          $this->GetFirst($this->division_style_h, $this->division_style), 
          $this->GetFirst($this->division_size_h, $this->division_size),
          $yoff);
        if(!empty($dx_path)) {
          $dx_colour = $this->GetFirst($this->division_colour_h,
            $this->division_colour, $this->axis_colour);
          if(isset($div_paths[$dx_colour]))
            $div_paths[$dx_colour] .= $dx_path;
          else
            $div_paths[$dx_colour] = $dx_path;
        }
      }
      if($this->show_axis_v) {
        for($i = 0; $i < $y_count; ++$i) {
          if(!is_null($this->y_axes[$i])) {
            $points = $this->GetGridPointsY($i);
            $dy_path = $this->YAxisDivisions($points,
              $i > 0 ? $this->y_axis_positions[$i] : $xoff, false, $i);
            if(!empty($dy_path)) {
              $dy_colour = $this->GetFirst(
                $this->ArrayOption($this->division_colour_v, $i),
                $this->division_colour,
                $this->ArrayOption($this->axis_colour_v, $i),
                $this->axis_colour);
              if(isset($div_paths[$dy_colour]))
                $div_paths[$dy_colour] .= $dy_path;
              else
                $div_paths[$dy_colour] = $dy_path;
            }
          }
        }
      }

      if($this->show_subdivisions) {
        if($this->show_axis_h) {
          $subdivs = $this->GetSubDivsX(0);
          $sdx_path = $this->XAxisDivisions($subdivs,
            $this->GetFirst($this->subdivision_style_h,
              $this->subdivision_style), 
            $this->GetFirst($this->subdivision_size_h,
              $this->subdivision_size), $yoff);

          if(!empty($sdx_path)) {
            $sdx_colour = $this->GetFirst($this->subdivision_colour_h,
              $this->subdivision_colour, $this->division_colour_h,
              $this->division_colour, $this->axis_colour);
            if(isset($div_paths[$sdx_colour]))
              $div_paths[$sdx_colour] .= $sdx_path;
            else
              $div_paths[$sdx_colour] = $sdx_path;
          }
        }
        if($this->show_axis_v) {
          for($i = 0; $i < $y_count; ++$i) {
            if(!is_null($this->y_axes[$i])) {
              $subdivs = $this->GetSubDivsY($i);
              $sdy_path = $this->YAxisDivisions($subdivs,
                $i > 0 ? $this->y_axis_positions[$i] : $xoff, true, $i);
              if(!empty($sdy_path)) {
                $sdy_colour = $this->GetFirst(
                  $this->ArrayOption($this->subdivision_colour_v, $i),
                  $this->subdivision_colour,
                  $this->ArrayOption($this->division_colour_v, $i),
                  $this->division_colour,
                  $this->ArrayOption($this->axis_colour_v, $i),
                  $this->axis_colour);
                if(isset($div_paths[$sdy_colour]))
                  $div_paths[$sdy_colour] .= $sdy_path;
                else
                  $div_paths[$sdy_colour] = $sdy_path;
              }
            }
          }
        }
      }

      foreach($div_paths as $colour => $path) {
        $div = array(
          'd' => $path,
          'stroke-width' => 1,
          'stroke' => $colour
        );
        $divisions .= $this->Element('path', $div);
      }
    }
    return $divisions . $axis_group . $label_group;
  }

  /**
   * Returns a set of gridlines
   */
  protected function GridLines($path, $colour, $dash, $fill = null)
  {
    if($path == '' || $colour == 'none')
      return '';
    $opts = array('d' => $path, 'stroke' => $colour);
    if(!empty($dash))
      $opts['stroke-dasharray'] = $dash;
    if(!empty($fill))
      $opts['fill'] = $fill;
    return $this->Element('path', $opts);
  }


  /**
   * Adds crosshairs to the grid
   */
  protected function GridCrossHairs(&$grid_group)
  {
    if(!$this->crosshairs || 
      !($this->crosshairs_show_v || $this->crosshairs_show_h))
      return '';

    $grid_id = $this->NewID();

    $grid_group['class'] = 'grid';

    // make the crosshair lines
    $crosshairs = '';
    $ch = array(
      'x1' => $this->pad_left, 'y1' => $this->pad_top,
      'x2' => $this->pad_left, 'y2' => $this->pad_top,
      'visibility' => 'hidden', // don't show them to start with!
    );

    // horizontal hair first
    $hch = array('class' => 'chX', 'x2' => $ch['x1'] + $this->g_width);
    if($this->crosshairs_show_h) {
      $hch['stroke'] = $this->SolidColour(
        $this->GetFirst($this->crosshairs_colour_h, $this->crosshairs_colour));
      $hch['stroke-width'] = $this->GetFirst($this->crosshairs_stroke_width_h,
        $this->crosshairs_stroke_width);
      $opacity = $this->GetFirst($this->crosshairs_opacity_h,
        $this->crosshairs_opacity);
      if($opacity > 0 && $opacity < 1)
        $hch['opacity'] = $opacity;
      $dash = $this->GetFirst($this->crosshairs_dash_h, $this->crosshairs_dash);
      if(!empty($dash))
        $hch['stroke-dasharray'] = $dash;
    }
    $crosshairs .= $this->Element('line', array_merge($ch, $hch));

    // vertical hair
    $hch = array('class' => 'chY', 'y2' => $ch['y1'] + $this->g_height);
    if($this->crosshairs_show_v) {
      $hch['stroke'] = $this->SolidColour(
        $this->GetFirst($this->crosshairs_colour_v, $this->crosshairs_colour));
      $hch['stroke-width'] = $this->GetFirst($this->crosshairs_stroke_width_v,
        $this->crosshairs_stroke_width);
      $opacity = $this->GetFirst($this->crosshairs_opacity_v,
        $this->crosshairs_opacity);
      if($opacity > 0 && $opacity < 1)
        $hch['opacity'] = $opacity;
      $dash = $this->GetFirst($this->crosshairs_dash_v, $this->crosshairs_dash);
      if(!empty($dash))
        $hch['stroke-dasharray'] = $dash;
    }
    $crosshairs .= $this->Element('line', array_merge($ch, $hch));

    // text group for grid details
    $text_group = array('id' => $this->NewId(), 'visibility' => 'hidden');
    $text_rect = array(
      'x' => '0', 'y' => '0', 'width' => '10', 'height' => '10',
      'fill' => $this->ParseColour($this->crosshairs_text_back_colour),
    );
    if($this->crosshairs_text_round)
      $text_rect['rx'] = $text_rect['ry'] = $this->crosshairs_text_round;
    if($this->crosshairs_text_stroke_width) {
      $text_rect['stroke-width'] = $this->crosshairs_text_stroke_width;
      $text_rect['stroke'] = $this->crosshairs_text_colour;
    }
    $font_size = max(3, (int)$this->crosshairs_text_font_size);
    $text_element = array(
      'x' => 0, 'y' => $font_size,
      'font-family' => $this->crosshairs_text_font,
      'font-size' => $font_size,
      'fill' => $this->crosshairs_text_colour,
    );
    $weight = $this->crosshairs_text_font_weight;
    if($weight && $weight != 'normal')
      $text_element['font-weight'] = $weight;

    $svg_text = new SVGGraphText($this);
    $text = $this->Element('g', $text_group, NULL,
      $this->Element('rect', $text_rect) . $svg_text->Text('', $font_size, 
        $text_element));
    $this->AddBackMatter($text);

    // add in the details of the grid scales
    $x_axis = $this->x_axes[$this->main_x_axis];
    $y_axis = $this->y_axes[$this->main_y_axis];
    $zero_x = $x_axis->Zero();
    $scale_x = $x_axis->Unit();
    $zero_y = $y_axis->Zero();
    $scale_y = $y_axis->Unit();
    $prec_x = $this->GetFirst($this->crosshairs_text_precision_h,
      max(0, ceil(log10($scale_x))));
    $prec_y = $this->GetFirst($this->crosshairs_text_precision_v,
      max(0, ceil(log10($scale_y))));

    $units = $base_y = $base_x = '';
    $u = $x_axis->AfterUnits();
    if(!empty($u)) $units .= " unitsx=\"{$u}\"";
    $u = $y_axis->AfterUnits();
    if(!empty($u)) $units .= " unitsy=\"{$u}\"";
    $u = $x_axis->BeforeUnits();
    if(!empty($u)) $units .= " unitsbx=\"{$u}\"";
    $u = $y_axis->BeforeUnits();
    if(!empty($u)) $units .= " unitsby=\"{$u}\"";

    // names of which string function to use for each axis
    $function_x = 'strValueX';
    $function_y = 'strValueY';
    $extra_x = $extra_y = '';

    if($this->log_axis_y) {
      if($this->flip_axes) {
        $base_x = " base=\"{$this->log_axis_y_base}\"";
        $zero_x = $x_axis->Value(0);
        $scale_x = $x_axis->Value($this->g_width);
        $this->javascript->AddFunction('logStrValueX');
        $function_x = 'logStrValueX';
      } else {
        $base_y = " base=\"{$this->log_axis_y_base}\"";
        $zero_y = $y_axis->Value(0);
        $scale_y = $y_axis->Value($this->g_height);
        $this->javascript->AddFunction('logStrValueY');
        $function_y = 'logStrValueY';
      }
    }

    if($this->datetime_keys &&
      (method_exists($x_axis, 'GetFormat') ||
      method_exists($y_axis, 'GetFormat'))) {
      if($this->flip_axes) {
        $zy = (int)$y_axis->Value(0);
        $ey = (int)$y_axis->Value($this->g_width);
        $scale_y = ($ey - $zy) / $this->g_height;
        $dt = new DateTime('@' . $zy);
        $zero_y = $dt->Format('c');
        $this->javascript->AddFunction('dateStrValueY');
        $function_y = 'dateStrValueY';
        $extra_y = ' format="' .
          htmlspecialchars($y_axis->GetFormat(), ENT_COMPAT,
            $this->encoding) . '"';
      } else {
        $zx = (int)$x_axis->Value(0);
        $ex = (int)$x_axis->Value($this->g_width);
        $scale_x = ($ex - $zx) / $this->g_width;
        $dt = new DateTime('@' . $zx);
        $zero_x = $dt->Format('c');
        $this->javascript->AddFunction('dateStrValueX');
        $function_x = 'dateStrValueX';
        $extra_x = ' format="' .
          htmlspecialchars($x_axis->GetFormat(), ENT_COMPAT,
            $this->encoding) . '"';
      }
    }

    // build associative data keys XML
    $keys_xml = '';
    if($this->values->AssociativeKeys()) {

      $k_max = $this->GetMaxKey();
      $keys_xml .= "  <svggraph:keys>\n";
      for($i = 0; $i <= $k_max; ++$i) {
        $k = $this->GetKey($i);
        $key = htmlspecialchars($k, ENT_COMPAT, $this->encoding);
        $keys_xml .= "    <svggraph:key value=\"{$key}\"/>\n";
      }
      $keys_xml .= "  </svggraph:keys>\n";

      // choose a rounding function
      $round_function = 'kround';
      if($this->label_centre)
        $round_function = 'kroundDown';
      $this->javascript->AddFunction($round_function);

      // set the string function
      if($this->flip_axes) {
        $this->javascript->AddFunction('keyStrValueY');
        $function_y = 'keyStrValueY';
        $extra_y = " round=\"{$round_function}\"";
      } else {
        $this->javascript->AddFunction('keyStrValueX');
        $function_x = 'keyStrValueX';
        $extra_x = " round=\"{$round_function}\"";
      }
    }
    // add details of scale to defs section for use by JS functions
    $defs = <<<XML
<svggraph:data xmlns:svggraph="http://www.goat1000.com/svggraph">
  <svggraph:gridx function="{$function_x}"{$extra_x} zero="{$zero_x}" scale="{$scale_x}" precision="{$prec_x}"{$base_x}/>
  <svggraph:gridy function="{$function_y}"{$extra_y} zero="{$zero_y}" scale="{$scale_y}" precision="{$prec_y}"{$base_y}/>
  <svggraph:chtext>
    <svggraph:chtextitem type="xy" groupid="{$text_group['id']}"$units/>
  </svggraph:chtext>
{$keys_xml}</svggraph:data>

XML;
    $this->defs[] = $defs;

    // add the main function at the end - it can fill in any defaults
    $this->javascript->AddFunction('crosshairs');
    return $crosshairs;
  }

  /**
   * Draws the grid behind the bar / line graph
   */
  protected function Grid()
  {
    $this->CalcAxes();
    $this->CalcGrid();

    $back = $subpath = $path_h = $path_v = '';
    $grid_group = array();
    $crosshairs = $this->GridCrossHairs($grid_group);

    // if the grid is not displayed, stop now
    if(!$this->show_grid || (!$this->show_grid_h && !$this->show_grid_v))
      return empty($crosshairs) ? '' :
        $this->Element('g', $grid_group, NULL, $crosshairs);

    $back_colour = $this->ParseColour($this->grid_back_colour);
    if(!empty($back_colour) && $back_colour != 'none') {

      $rect = array(
        'x' => $this->pad_left, 'y' => $this->pad_top,
        'width' => $this->g_width, 'height' => $this->g_height,
        'fill' => $back_colour
      );
      if($this->grid_back_opacity != 1)
        $rect['fill-opacity'] = $this->grid_back_opacity;
      $back = $this->Element('rect', $rect);
    }
    if($this->grid_back_stripe) {
      // use array of colours if available, otherwise stripe a single colour
      $colours = is_array($this->grid_back_stripe_colour) ?
        $this->grid_back_stripe_colour :
        array(NULL, $this->grid_back_stripe_colour);
      $grp = array();
      $bars = '';
      $c = 0;
      $num_colours = count($colours);
      if($this->flip_axes) {
        $rect = array('y' => $this->pad_top, 'height' => $this->g_height);
        if($this->grid_back_stripe_opacity != 1)
          $rect['fill-opacity'] = $this->grid_back_stripe_opacity;
        $points = $this->GetGridPointsX($this->main_x_axis);
        $first = array_shift($points);
        $last_pos = $first->position;
        foreach($points as $grid_point) {
          if(!is_null($colours[$c % $num_colours])) {
            $rect['x'] = $last_pos;
            $rect['width'] = $grid_point->position - $last_pos;
            $rect['fill'] = $this->ParseColour($colours[$c % $num_colours]);
            $bars .= $this->Element('rect', $rect);
          }
          $last_pos = $grid_point->position;
          ++$c;
        }
      } else {
        $rect = array('x' => $this->pad_left, 'width' => $this->g_width);
        if($this->grid_back_stripe_opacity != 1)
          $rect['fill-opacity'] = $this->grid_back_stripe_opacity;
        $points = $this->GetGridPointsY($this->main_y_axis);
        $first = array_shift($points);
        $last_pos = $first->position;
        foreach($points as $grid_point) {
          if(!is_null($colours[$c % $num_colours])) {
            $rect['y'] = $grid_point->position;
            $rect['height'] = $last_pos - $grid_point->position;
            $rect['fill'] = $this->ParseColour($colours[$c % $num_colours]);
            $bars .= $this->Element('rect', $rect);
          }
          $last_pos = $grid_point->position;
          ++$c;
        }
      }
      $back .= $this->Element('g', $grp, null, $bars);
    }
    if($this->show_grid_subdivisions) {
      $subpath_h = $subpath_v = '';
      if($this->show_grid_h) {
        $subdivs = $this->GetSubDivsY($this->main_y_axis);
        foreach($subdivs as $y) 
          $subpath_v .= "M{$this->pad_left} {$y->position}h{$this->g_width}";
      }
      if($this->show_grid_v){
        $subdivs = $this->GetSubDivsX(0);
        foreach($subdivs as $x) 
          $subpath_h .= "M{$x->position} {$this->pad_top}v{$this->g_height}";
      }

      if($subpath_h != '' || $subpath_v != '') {
        $colour_h = $this->GetFirst($this->grid_subdivision_colour_h,
          $this->grid_subdivision_colour, $this->grid_colour_h,
          $this->grid_colour);
        $colour_v = $this->GetFirst($this->grid_subdivision_colour_v,
          $this->grid_subdivision_colour, $this->grid_colour_v,
          $this->grid_colour);
        $dash_h = $this->GetFirst($this->grid_subdivision_dash_h,
          $this->grid_subdivision_dash, $this->grid_dash_h, $this->grid_dash);
        $dash_v = $this->GetFirst($this->grid_subdivision_dash_v,
          $this->grid_subdivision_dash, $this->grid_dash_v, $this->grid_dash);

        if($dash_h == $dash_v && $colour_h == $colour_v) {
          $subpath = $this->GridLines($subpath_h . $subpath_v, $colour_h,
            $dash_h);
        } else {
          $subpath = $this->GridLines($subpath_h, $colour_h, $dash_h) .
            $this->GridLines($subpath_v, $colour_v, $dash_v);
        }
      }
    }

    if($this->show_grid_h) {
      $points = $this->GetGridPointsY($this->main_y_axis);
      foreach($points as $y) 
        $path_v .= "M{$this->pad_left} {$y->position}h{$this->g_width}";
    }
    if($this->show_grid_v) {
      $points = $this->GetGridPointsX($this->main_x_axis);
      foreach($points as $x) 
        $path_h .= "M{$x->position} {$this->pad_top}v{$this->g_height}";
    }

    $colour_h = $this->GetFirst($this->grid_colour_h, $this->grid_colour);
    $colour_v = $this->GetFirst($this->grid_colour_v, $this->grid_colour);
    $dash_h = $this->GetFirst($this->grid_dash_h, $this->grid_dash);
    $dash_v = $this->GetFirst($this->grid_dash_v, $this->grid_dash);

    if($dash_h == $dash_v && $colour_h == $colour_v) {
      $path = $this->GridLines($path_v . $path_h, $colour_h, $dash_h);
    } else {
      $path = $this->GridLines($path_h, $colour_h, $dash_h) .
        $this->GridLines($path_v, $colour_v, $dash_v);
    }

    return $this->Element('g', $grid_group, NULL,
      $back . $subpath . $path . $crosshairs);
  }

  /**
   * clamps a value to the grid boundaries
   */
  protected function ClampVertical($val)
  {
    return max($this->pad_top, min($this->height - $this->pad_bottom, $val));
  }

  protected function ClampHorizontal($val)
  {
    return max($this->pad_left, min($this->width - $this->pad_right, $val));
  }

  /**
   * Sets the clipping path for the grid
   */
  protected function ClipGrid(&$attr)
  {
    $clip_id = $this->GridClipPath();
    $attr['clip-path'] = "url(#{$clip_id})";
  }

  /**
   * Returns the ID of the grid clipping path
   */
  public function GridClipPath()
  {
    if(isset($this->grid_clip_id))
      return $this->grid_clip_id;

    $rect = array(
      'x' => $this->pad_left, 'y' => $this->pad_top,
      'width' => $this->width - $this->pad_left - $this->pad_right,
      'height' => $this->height - $this->pad_top - $this->pad_bottom
    );
    $clip_id = $this->NewID();
    $this->defs[] = $this->Element('clipPath', array('id' => $clip_id),
      NULL, $this->Element('rect', $rect));
    return ($this->grid_clip_id = $clip_id);
  }

  /**
   * Returns the grid position for a bar or point, or NULL if not on grid
   * $item  = data item
   * $index = integer position in array
   */
  protected function GridPosition($item, $index)
  {
    $position = null;
    $axis = $this->flip_axes ? $this->y_axes[$this->main_y_axis] :
      $this->x_axes[$this->main_x_axis];
    $offset = $axis->Position($index, $item);
    $zero = -0.01; // catch values close to 0
    if($offset >= $zero && floor($offset) <= $this->grid_limit) {
      if($this->flip_axes)
        $position = $this->height - $this->pad_bottom - $offset;
      else
        $position = $this->pad_left + $offset;
    }
    return $position;
  }

  /**
   * Returns an X unit value as a SVG distance
   */
  public function UnitsX($x, $axis_no = NULL)
  {
    if(is_null($axis_no))
      $axis_no = $this->main_x_axis;
    if(!isset($this->x_axes[$axis_no]))
      throw new Exception("Axis x$axis_no does not exist");
    if(is_null($this->x_axes[$axis_no]))
      $axis_no = $this->main_x_axis;
    $axis = $this->x_axes[$axis_no];
    return $axis->Position($x);
  }

  /**
   * Returns a Y unit value as a SVG distance
   */
  public function UnitsY($y, $axis_no = NULL)
  {
    if(is_null($axis_no))
      $axis_no = $this->main_y_axis;
    if(!isset($this->y_axes[$axis_no]))
      throw new Exception("Axis y$axis_no does not exist");
    if(is_null($this->y_axes[$axis_no]))
      $axis_no = $this->main_y_axis;
    $axis = $this->y_axes[$axis_no];
    return $axis->Position($y);
  }

  /**
   * Returns the $x value as a grid position
   */
  public function GridX($x, $axis_no = NULL)
  {
    $p = $this->UnitsX($x, $axis_no);
    if(!is_null($p))
      return $this->pad_left + $p;
    return null;
  }

  /**
   * Returns the $y value as a grid position
   */
  public function GridY($y, $axis_no = NULL)
  {
    $p = $this->UnitsY($y, $axis_no);
    if(!is_null($p))
      return $this->height - $this->pad_bottom - $p;
    return null;
  }

  /**
   * Returns the location of the X axis origin
   */
  protected function OriginX($axis_no = NULL)
  {
    if(is_null($axis_no) || is_null($this->x_axes[$axis_no]))
      $axis_no = $this->main_x_axis;
    $axis = $this->x_axes[$axis_no];
    return $this->pad_left + $axis->Origin();
  }

  /**
   * Returns the location of the Y axis origin
   */
  protected function OriginY($axis_no = NULL)
  {
    if(is_null($axis_no) || is_null($this->y_axes[$axis_no]))
      $axis_no = $this->main_y_axis;
    $axis = $this->y_axes[$axis_no];
    return $this->height - $this->pad_bottom - $axis->Origin();
  }

  /**
   * Converts guideline options to more useful member variables
   */
  protected function CalcGuidelines()
  {
    // no guidelines?
    if(empty($this->guideline) && $this->guideline !== 0)
      return;

    require_once 'SVGGraphGuidelines.php';
    $this->guidelines = new Guidelines($this->settings, $this, $this->flip_axes,
      $this->values->AssociativeKeys(), $this->datetime_keys);
  }

  public function UnderShapes()
  {
    $content = parent::UnderShapes();
    if(!is_null($this->guidelines))
      $content .= $this->guidelines->GetBelow();
    return $content;
  }

  public function OverShapes()
  {
    $content = parent::OverShapes();
    if(!is_null($this->guidelines))
      $content .= $this->guidelines->GetAbove();
    return $content;
  }

}

