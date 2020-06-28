<?php 
/**
 *  Red Cherries Accounting is a web based accounting software solution 
 *  for Small and Medium Enterprices (SME) to manage financial information. 
 *  Copyright (C) 2020  Artifectx Solutions (Pvt) Ltd
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */
?>

</div>
</section>
</div>
</div>
<?php
if ($show_footer) { ?>
  <footer id='footer'>
    <div class='footer-wrapper'>

        Red Cherries Accounting Version <?php echo $version_no ?>
        <br>
        Copyright © 2020 Red Cherries Accounting By Artifectx


  </footer>
  <?php
}
?>
<!-- Following four scripts should load in the given order in order to work date and time picker properly. So do not change the order -->

<!-- / jquery [required] -->
<script src="<?php echo base_url();?>assets/javascripts/jquery/jquery.min.js" type="text/javascript"></script>
<!-- / bootstrap [required] -->
<script src="<?php echo base_url();?>assets/javascripts/bootstrap/bootstrap.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/javascripts/plugins/moment-with-locales/moment-with-locales.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/javascripts/plugins/bootstrap_datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>

<!--------------------------------------------------------------------------------------------------------------------------------->

<!-- / jquery mobile (for touch events) -->
<script src="<?php echo base_url();?>assets/javascripts/jquery/jquery.mobile.custom.min.js" type="text/javascript"></script>
<!-- / jquery migrate (for compatibility with new jquery) [required] -->
<script src="<?php echo base_url();?>assets/javascripts/jquery/jquery-migrate.min.js" type="text/javascript"></script>
<!-- / jquery ui -->
<script src="<?php echo base_url();?>assets/javascripts/jquery/jquery-ui.min.js" type="text/javascript"></script>
<!-- / jQuery UI Touch Punch -->
<script src="<?php echo base_url();?>assets/javascripts/plugins/jquery_ui_touch_punch/jquery.ui.touch-punch.min.js" type="text/javascript"></script>

<!-- / modernizr -->
<script src="<?php echo base_url();?>assets/javascripts/plugins/modernizr/modernizr.min.js" type="text/javascript"></script>
<!-- / retina -->
<script src="<?php echo base_url();?>assets/javascripts/plugins/retina/retina.js" type="text/javascript"></script>
<!-- / theme file [required] -->
<script src="<?php echo base_url();?>assets/javascripts/theme.js" type="text/javascript"></script>
<!-- / demo file [not required!] -->
<script src="<?php echo base_url();?>assets/javascripts/demo.js" type="text/javascript"></script>

<!-- / START - page related files and scripts [optional] -->
<script src="<?php echo base_url();?>assets/javascripts/plugins/flot/excanvas.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/javascripts/plugins/flot/flot.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/javascripts/plugins/flot/flot.resize.js" type="text/javascript"></script>

<script src="<?php echo base_url();?>assets/javascripts/plugins/validate/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/javascripts/plugins/validate/additional-methods.js" type="text/javascript"></script>

<script src="<?php echo base_url();?>assets/javascripts/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/javascripts/plugins/datatables/jquery.dataTables.columnFilter.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/javascripts/plugins/datatables/dataTables.overrides.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/javascripts/plugins/select2/select2.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/javascripts/plugins/circular_progress_bar/jQuery-plugin-progressbar.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/javascripts/plugins/typeahead/typeahead.bundle.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/javascripts/plugins/handlebars/handlebars.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/javascripts/plugins/raphael/raphael.js" type="text/javascript"></script>

<script src="<?php echo base_url();?>assets/javascripts/plugins/jstree/jstree.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/javascripts/intlTelInput.js" type="text/javascript"></script>
<!--<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js" type="text/javascript"></script>-->
<script>
  $.validator.addMethod("buga", (function(value) {
    return value === "buga";
  }), "Please enter \"buga\"!");

  $.validator.methods.equal = function(value, element, param) {
    return value === param;
  };
</script>

<script>
  var data, dataset, gd, options, previousLabel, previousPoint, showTooltip, ticks;
  var blue, data, datareal, getRandomData, green, i, newOrders, options, orange, orders, placeholder, plot, purple, randNumber, randSmallerNumber, red, series, totalPoints, update, updateInterval;
  var red = "#f34541";
  var orange = "#f8a326";
  var blue = "#00acec";
  var purple = "#9564e2";
  var green = "#49bf67";
  randNumber = function() {
    return ((Math.floor(Math.random() * (1 + 50 - 20))) + 20) * 800;
  };
  randSmallerNumber = function() {
    return ((Math.floor(Math.random() * (1 + 40 - 20))) + 10) * 200;
  };
  if ($("#stats-chart1").length !== 0) {
    orders = [[1, randNumber() - 10], [2, randNumber() - 10], [3, randNumber() - 10], [4, randNumber()], [5, randNumber()], [6, 4 + randNumber()], [7, 5 + randNumber()], [8, 6 + randNumber()], [9, 6 + randNumber()], [10, 8 + randNumber()], [11, 9 + randNumber()], [12, 10 + randNumber()], [13, 11 + randNumber()], [14, 12 + randNumber()], [15, 13 + randNumber()], [16, 14 + randNumber()], [17, 15 + randNumber()], [18, 15 + randNumber()], [19, 16 + randNumber()], [20, 17 + randNumber()], [21, 18 + randNumber()], [22, 19 + randNumber()], [23, 20 + randNumber()], [24, 21 + randNumber()], [25, 14 + randNumber()], [26, 24 + randNumber()], [27, 25 + randNumber()], [28, 26 + randNumber()], [29, 27 + randNumber()], [30, 31 + randNumber()]];
    newOrders = [[1, randSmallerNumber() - 10], [2, randSmallerNumber() - 10], [3, randSmallerNumber() - 10], [4, randSmallerNumber()], [5, randSmallerNumber()], [6, 4 + randSmallerNumber()], [7, 5 + randSmallerNumber()], [8, 6 + randSmallerNumber()], [9, 6 + randSmallerNumber()], [10, 8 + randSmallerNumber()], [11, 9 + randSmallerNumber()], [12, 10 + randSmallerNumber()], [13, 11 + randSmallerNumber()], [14, 12 + randSmallerNumber()], [15, 13 + randSmallerNumber()], [16, 14 + randSmallerNumber()], [17, 15 + randSmallerNumber()], [18, 15 + randSmallerNumber()], [19, 16 + randSmallerNumber()], [20, 17 + randSmallerNumber()], [21, 18 + randSmallerNumber()], [22, 19 + randSmallerNumber()], [23, 20 + randSmallerNumber()], [24, 21 + randSmallerNumber()], [25, 14 + randSmallerNumber()], [26, 24 + randSmallerNumber()], [27, 25 + randSmallerNumber()], [28, 26 + randSmallerNumber()], [29, 27 + randSmallerNumber()], [30, 31 + randSmallerNumber()]];
    plot = $.plot($("#stats-chart1"), [
      {
        data: orders,
        label: "Orders"
      }, {
        data: newOrders,
        label: "New rders"
      }
    ], {
      series: {
        lines: {
          show: true,
          lineWidth: 3
        },
        shadowSize: 0
      },
      legend: {
        show: false
      },
      grid: {
        clickable: true,
        hoverable: true,
        borderWidth: 0,
        tickColor: "#f4f7f9"
      },
      colors: ["#00acec", "#f8a326"]
    });
  }
  if ($("#stats-chart2").length !== 0) {
    orders = [[1, randNumber() - 5], [2, randNumber() - 6], [3, randNumber() - 10], [4, randNumber()], [5, randNumber()], [6, 4 + randNumber()], [7, 10 + randNumber()], [8, 12 + randNumber()], [9, 6 + randNumber()], [10, 8 + randNumber()], [11, 9 + randNumber()], [12, 10 + randNumber()], [13, 11 + randNumber()], [14, 12 + randNumber()], [15, 3 + randNumber()], [16, 14 + randNumber()], [17, 14 + randNumber()], [18, 15 + randNumber()], [19, 16 + randNumber()], [20, 17 + randNumber()], [21, 18 + randNumber()], [22, 19 + randNumber()], [23, 20 + randNumber()], [24, 21 + randNumber()], [25, 14 + randNumber()], [26, 24 + randNumber()], [27, 25 + randNumber()], [28, 26 + randNumber()], [29, 27 + randNumber()], [30, 31 + randNumber()]];
    newOrders = [[1, randSmallerNumber() - 10], [2, randSmallerNumber() - 10], [3, randSmallerNumber() - 10], [4, randSmallerNumber()], [5, randSmallerNumber()], [6, 4 + randSmallerNumber()], [7, 5 + randSmallerNumber()], [8, 6 + randSmallerNumber()], [9, 6 + randSmallerNumber()], [10, 8 + randSmallerNumber()], [11, 9 + randSmallerNumber()], [12, 10 + randSmallerNumber()], [13, 11 + randSmallerNumber()], [14, 12 + randSmallerNumber()], [15, 13 + randSmallerNumber()], [16, 14 + randSmallerNumber()], [17, 15 + randSmallerNumber()], [18, 15 + randSmallerNumber()], [19, 16 + randSmallerNumber()], [20, 17 + randSmallerNumber()], [21, 18 + randSmallerNumber()], [22, 19 + randSmallerNumber()], [23, 20 + randSmallerNumber()], [24, 21 + randSmallerNumber()], [25, 14 + randSmallerNumber()], [26, 24 + randSmallerNumber()], [27, 25 + randSmallerNumber()], [28, 26 + randSmallerNumber()], [29, 27 + randSmallerNumber()], [30, 31 + randSmallerNumber()]];
    plot = $.plot($("#stats-chart2"), [
      {
        data: orders,
        label: "Orders"
      }, {
        data: newOrders,
        label: "New orders"
      }
    ], {
      series: {
        lines: {
          show: true,
          lineWidth: 3
        },
        shadowSize: 0
      },
      legend: {
        show: false
      },
      grid: {
        clickable: true,
        hoverable: true,
        borderWidth: 0,
        tickColor: "#f4f7f9"
      },
      colors: ["#f34541", "#49bf67"]
    });
    $("#stats-chart2").bind("plotclick", function(event, pos, item) {
      if (item) {
        return alert("Yeah! You just clicked on point " + item.dataIndex + " in " + item.series.label + ".");
      }
    });
  }
</script>
<script src="<?php echo base_url();?>assets/javascripts/plugins/common/moment.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/javascripts/plugins/bootstrap_daterangepicker/bootstrap-daterangepicker.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/javascripts/plugins/bootstrap_daterangepicker/bootstrap-daterangepicker.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/javascripts/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/javascripts/plugins/slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/javascripts/plugins/timeago/jquery.timeago.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/javascripts/plugins/common/wysihtml5.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/javascripts/plugins/common/bootstrap-wysihtml5.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/javascripts/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/javascripts/plugins/bootstrap_switch/bootstrapSwitch.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/javascripts/plugins/fuelux/wizard.js"></script>
<script src="<?php echo base_url(); ?>assets/javascripts/plugins/tabdrop/bootstrap-tabdrop.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/javascripts/plugins/pwstrength/pwstrength.js" type="text/javascript"></script>

<script>
  $(".chat .new-message").live('submit', function(e) {
    var chat, date, li, message, months, reply, scrollable, sender, timeago;
    date = new Date();
    months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    chat = $(this).parents(".chat");
    message = $(this).find("#message_body").val();
    $(this).find("#message_body").val("");
    if (message.length !== 0) {
      li = chat.find("li.message").first().clone();
      li.find(".body").text(message);
      timeago = li.find(".timeago");
      timeago.removeClass("in");
      var month = (date.getMonth() + 1);
      var date_day = (date.getDate());
      timeago.attr("title", "" + (date.getFullYear()) + "-" + (month<10 ? '0' : '') + month + "-" + (date_day<10 ? '0' : '' ) + date_day + " " + (date.getHours()) + ":" + (date.getMinutes()) + ":" + (date.getSeconds()) + " +0200");
      timeago.text("" + months[date.getMonth()] + " " + (date.getDate()) + ", " + (date.getFullYear()) + " " + (date.getHours()) + ":" + (date.getMinutes()));
      setTimeAgo(timeago);
      sender = li.find(".name").text().trim();
      chat.find("ul").append(li);
      scrollable = li.parents(".scrollable");
      $(scrollable).slimScroll({
        scrollTo: scrollable.prop('scrollHeight') + "px"
      });
      li.effect("highlight", {}, 500);
      reply = scrollable.find("li").not(":contains('" + sender + "')").first().clone();
      setTimeout((function() {
        date = new Date();
        timeago = reply.find(".timeago");
        timeago.attr("title", "" + (date.getFullYear()) + "-" + (month<10 ? '0' : '') + month + "-" + (date_day<10 ? '0' : '' ) + date_day + " " + (date.getHours()) + ":" + (date.getMinutes()) + ":" + (date.getSeconds()) + " +0200");
        timeago.text("" + months[date.getMonth()] + " " + (date.getDate()) + ", " + (date.getFullYear()) + " " + (date.getHours()) + ":" + (date.getMinutes()));
        setTimeAgo(timeago);
        scrollable.find("ul").append(reply);
        $(scrollable).slimScroll({
          scrollTo: scrollable.prop('scrollHeight') + "px"
        });
        return reply.effect("highlight", {}, 500);
      }), 1000);
    }
    return e.preventDefault();
  });
</script>
<script>
  $(".recent-activity .ok").live("click", function(e) {
    $(this).tooltip("hide");
    $(this).parents("li").fadeOut(500, function() {
      return $(this).remove();
    });
    return e.preventDefault();
  });
  $(".recent-activity .remove").live("click", function(e) {
    $(this).tooltip("hide");
    $(this).parents("li").fadeOut(500, function() {
      return $(this).remove();
    });
    return e.preventDefault();
  });
  $("#comments-more-activity").live("click", function(e) {
    $(this).button("loading");
    setTimeout((function() {
      var list;
      list = $("#comments-more-activity").parent().parent().find("ul");
      list.append(list.find("li:not(:first)").clone().effect("highlight", {}, 500));
      return $("#comments-more-activity").button("reset");
    }), 1000);
    e.preventDefault();
    return false;
  });
  $("#users-more-activity").live("click", function(e) {
    $(this).button("loading");
    setTimeout((function() {
      var list;
      list = $("#users-more-activity").parent().parent().find("ul");
      list.append(list.find("li:not(:first)").clone().effect("highlight", {}, 500));
      return $("#users-more-activity").button("reset");
    }), 1000);
    e.preventDefault();
    return false;
  });
</script>
<script>
  (function() {
    $("#daterange").daterangepicker({
      ranges: {
        Yesterday: [moment().subtract("days", 1), moment().subtract("days", 1)],
        "Last 30 Days": [moment().subtract("days", 29), moment()],
        "This Month": [moment().startOf("month"), moment().endOf("month")]
      },
      startDate: moment().subtract("days", 29),
      endDate: moment(),
      opens: "left",
      cancelClass: "btn-danger",
      buttonClasses: ['btn', 'btn-sm']
    }, function(start, end) {
      return $("#daterange span").html(start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY"));
    });

  }).call(this);
</script>
<script>
  $(".todo-list .new-todo").live('submit', function(e) {
    var li, todo_name;
    todo_name = $(this).find("#todo_name").val();
    $(this).find("#todo_name").val("");
    if (todo_name.length !== 0) {
      li = $(this).parents(".todo-list").find("li.item").first().clone();
      li.find("input[type='checkbox']").attr("checked", false);
      li.removeClass("important").removeClass("done");
      li.find("label.todo span").text(todo_name);
      $(".todo-list ul").first().prepend(li);
      li.effect("highlight", {}, 500);
    }
    return e.preventDefault();
  });

  $(".todo-list .actions .remove").live("click", function(e) {
    $(this).tooltip("hide");
    $(this).parents("li").fadeOut(500, function() {
      return $(this).remove();
    });
    e.stopPropagation();
    e.preventDefault();
    return false;
  });

  $(".todo-list .actions .important").live("click", function(e) {
    $(this).parents("li").toggleClass("important");
    e.stopPropagation();
    e.preventDefault();
    return false;
  });

  $(".todo-list .check").live("click", function() {
    var checkbox;
    checkbox = $(this).find("input[type='checkbox']");
    if (checkbox.is(":checked")) {
      return $(this).parents("li").addClass("done");
    } else {
      return $(this).parents("li").removeClass("done");
    }
  });


  /* $('#main-nav .navigation > .nav > li > a').css({"background-color":"#f34541"});*/
</script>

</body>

</html>
