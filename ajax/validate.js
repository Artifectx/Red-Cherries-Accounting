
// Return true if the input value is not empty
function isNotEmpty(inputId, errorMsg) {//alert("isNotEmpty")
    var inputElement = document.getElementById(inputId);
    var errorElement = document.getElementById(inputId + "Error");
    var inputValue = inputElement.value.trim();
    var isValid = (inputValue.length != 0);  // boolean
    showMessage(isValid, inputElement, errorMsg, errorElement);

    return isValid;
}

// Return true if the input value is not empty
function isEmpty(inputId, errorMsg) {//alert("isNotEmpty")
    var inputElement = document.getElementById(inputId);
    var errorElement = document.getElementById(inputId + "Error");
    var inputValue = inputElement.value.trim();
    var isValid = (inputValue.length == 0);  // boolean
    showMessage(isValid, inputElement, errorMsg, errorElement);

    return isValid;
}

/* If "isValid" is false, print the errorMsg; else, reset to normal display.
 * The errorMsg shall be displayed on errorElement if it exists;
 *   otherwise via an alert().
 */
function showMessage(isValid, inputElement, errorMsg, errorElement) {
    if (!isValid) {
        // Put up error message on errorElement or via alert()
        if (errorElement != null) {
           errorElement.innerHTML = errorMsg;
        } else {
           alert(errorMsg);
        }
        // Change "class" of inputElement, so that CSS displays differently
        if (inputElement != null) {
           //inputElement.className = "error";
           inputElement.className = "form-control";
           inputElement.focus();
        }
    }
    else {
        // Reset to normal display
        if (errorElement != null) {
           errorElement.innerHTML = "";

        }
        if (inputElement != null) {
           //inputElement.className = "txt";
            inputElement.className = "form-control";

        }
    }
}

// Return true if the input value contains only digits (at least one)
function isNumeric(inputId, errorMsg) {
    var inputElement = document.getElementById(inputId);
    var errorElement = document.getElementById(inputId + "Error");
    var inputValue = inputElement.value.trim();
    var isValid = (inputValue.search(/^[0-9]+$/) != -1);
    showMessage(isValid, inputElement, errorMsg, errorElement);
    return isValid;
}

// Return true if the input value contains only floot (at least one)
function isFloot(inputId, errorMsg) {
    var inputElement = document.getElementById(inputId);
    var errorElement = document.getElementById(inputId + "Error");
    var inputValue = inputElement.value.trim();
    var isValid = inputValue.match(/^[-+]?[0-9]+\.[0-9]+$/);
    showMessage(isValid, inputElement, errorMsg, errorElement);
    return isValid;
}

// Return true if the input value contains only positive floot (at least one)
function isFlootPositive(inputId, errorMsg) {
    var inputElement = document.getElementById(inputId);
    var errorElement = document.getElementById(inputId + "Error");
    var inputValue = inputElement.value.trim();
    var isValid = inputValue.match(/^[+]?[0-9]+\.[0-9]+$/);
    showMessage(isValid, inputElement, errorMsg, errorElement);
    return isValid;
}

// Return true if the input value contains only letters (at least one)
function isAlphabetic(inputId, errorMsg) {
    var inputElement = document.getElementById(inputId);
    var errorElement = document.getElementById(inputId + "Error");
    var inputValue = inputElement.value.trim();
    var isValid = inputValue.match(/^[a-zA-Z]+$/);
    showMessage(isValid, inputElement, errorMsg, errorElement);
    return isValid;
}

// Return true if the input value contains only digits and letters (at least one)
function isAlphanumeric(inputId, errorMsg) {
    var inputElement = document.getElementById(inputId);
    var errorElement = document.getElementById(inputId + "Error");
    var inputValue = inputElement.value.trim();
    var isValid = inputValue.match(/^[0-9a-zA-Z]+$/);
    showMessage(isValid, inputElement, errorMsg, errorElement);
    return isValid;
}

// Return true if the input length is between minLength and maxLength
function isLengthMinMax(inputId, errorMsg, minLength, maxLength) {
    var inputElement = document.getElementById(inputId);
    var errorElement = document.getElementById(inputId + "Error");
    var inputValue = inputElement.value.trim();
    var isValid = (inputValue.length >= minLength) && (inputValue.length <= maxLength);
    showMessage(isValid, inputElement, errorMsg, errorElement);
    return isValid;
}

function isTimeValid(inputId, errorMsg) {
    var inputElement = document.getElementById(inputId);
    var errorElement = document.getElementById(inputId + "Error");
    var inputValue = inputElement.value.trim();
    var timeAndType = inputValue.split(" ");
    var time = timeAndType[0].split(":");
    var isValid = false;
    if (timeAndType[1] === "AM") {
        if ((time[0].search(/^[0-9]+$/) !== -1) && time[0] < 12) {
            if ((time[1].search(/^[0-9]+$/) !== -1) && time[1] <= 59) {
                if ((time[2].search(/^[0-9]+$/) !== -1) && time[2] <= 59) {
	isValid = true;
                } else {
	isValid = false;
                }
            } else {
                isValid = false;
            }
        } else {
            isValid = false;
        }
    } else if (timeAndType[1] === "PM") {
        if ((time[0].search(/^[0-9]+$/) !== -1) && time[0] <= 12) {
            if ((time[1].search(/^[0-9]+$/) !== -1) && time[1] <= 59) {
                if ((time[2].search(/^[0-9]+$/) !== -1) && time[2] <= 59) {
	isValid = true;
                } else {
	isValid = false;
                }
            } else {
                isValid = false;
            }
        } else {
            isValid = false;
        }
    } else {
        isValid = false;
    }

    showMessage(isValid, inputElement, errorMsg, errorElement);
    return isValid;
}

// Return true if the input time value is equal to the reference time value
function isTimeEqual(inputId, errorMsg, referenceId) {
    var inputElement = document.getElementById(inputId);
    var referenceElement = document.getElementById(referenceId);
    var errorElement = document.getElementById(inputId + "Error");
    var inputValue = inputElement.value.trim();
    var referenceValue = referenceElement.value.trim();
    var isValid = ((inputValue) != (referenceValue));
    showMessage(isValid, inputElement, errorMsg, errorElement);
    return isValid;
}

// Return true if the input time value is greater than or equal the reference time value
function isTimeGreaterThanOrEqual(inputId, errorMsg, referenceId) {//alert("isTimeGreaterThanOrEqual")
    var inputElement = document.getElementById(inputId);
    var referenceElement = document.getElementById(referenceId);
    var errorElement = document.getElementById(inputId + "Error");
    var inputValue = inputElement.value.trim();
    var referenceValue = referenceElement.value.trim();

    var inputTimeBreakdown = inputValue.split(" ");
    var inputHoursMinutes = inputTimeBreakdown[0].split(":");
    var inputHours = parseInt(inputHoursMinutes[0]);
    var inputMinutes = parseInt(inputHoursMinutes[1]);
    var inputInSeconds = 0;
    if (inputTimeBreakdown[1] === "AM") {
        if (inputHours !== 12) {
            inputInSeconds = (inputHours * 3600) + (inputMinutes * 60);
        } else {
            inputInSeconds = inputMinutes * 60;
        }
    } else if (inputTimeBreakdown[1] === "PM") {
         if (inputHours !== 12) {
             inputInSeconds = ((inputHours + 12) * 3600) + (inputMinutes * 60);
         } else {
             inputInSeconds = (inputHours * 3600) + (inputMinutes * 60);
         }
    }

    var referenceTimeBreakdown = referenceValue.split(" ");
    var referenceHoursMinutes = referenceTimeBreakdown[0].split(":");
    var referenceHours = parseInt(referenceHoursMinutes[0]);
    var referenceMinutes = parseInt(referenceHoursMinutes[1]);
    var referenceInSeconds = 0;
    if (referenceTimeBreakdown[1] === "AM") {
        if (referenceHours !== 12) {
            referenceInSeconds = (referenceHours * 3600) + (referenceMinutes * 60);
        } else {
            referenceInSeconds = referenceMinutes * 60;
        }
    } else if (referenceTimeBreakdown[1] === "PM") {
         if (referenceHours !== 12) {
             referenceInSeconds = ((referenceHours + 12) * 3600) + (referenceMinutes * 60);
         } else {
             referenceInSeconds = (referenceHours * 3600) + (referenceMinutes * 60);
         }
    }
    //alert(inputId + " - " + inputInSeconds + " : " + referenceId + " - " + referenceInSeconds)
    var isValid = (inputInSeconds >= referenceInSeconds);
    showMessage(isValid, inputElement, errorMsg, errorElement);//alert(isValid)
    return isValid;
}

// Return true if the input time value is greater than the reference time value
function isTimeGreaterThan(inputId, errorMsg, referenceId) {//alert("isTimeGreaterThan");alert(inputId);alert(referenceId);
    var inputElement = document.getElementById(inputId);
    var referenceElement = document.getElementById(referenceId);
    var errorElement = document.getElementById(inputId + "Error");
    var inputValue = inputElement.value.trim();
    var referenceValue = referenceElement.value.trim();
    //alert(inputId + " - " + inputValue + " : " + referenceId + " - " + referenceValue)
    var inputTimeBreakdown = inputValue.split(" ");
    var inputHoursMinutes = inputTimeBreakdown[0].split(":");
    var inputHours = parseInt(inputHoursMinutes[0]);
    var inputMinutes = parseInt(inputHoursMinutes[1]);
    var inputInSeconds = 0;
    if (inputTimeBreakdown[1] === "AM") {
        if (inputHours !== 12) {
            inputInSeconds = (inputHours * 3600) + (inputMinutes * 60);
        } else {
            inputInSeconds = inputMinutes * 60;
        }
    } else if (inputTimeBreakdown[1] === "PM") {
        if (inputHours !== 12) {
             inputInSeconds = ((inputHours + 12) * 3600) + (inputMinutes * 60);
         } else {
             inputInSeconds = (inputHours * 3600) + (inputMinutes * 60);
         }
    }

    var referenceTimeBreakdown = referenceValue.split(" ");
    var referenceHoursMinutes = referenceTimeBreakdown[0].split(":");
    var referenceHours = parseInt(referenceHoursMinutes[0]);
    var referenceMinutes = parseInt(referenceHoursMinutes[1]);
    var referenceInSeconds = 0;
    if (referenceTimeBreakdown[1] === "AM") {
        if (referenceHours !== 12) {
            referenceInSeconds = (referenceHours * 3600) + (referenceMinutes * 60);
        } else {
            referenceInSeconds = referenceMinutes * 60;
        }
    } else if (referenceTimeBreakdown[1] === "PM") {
        if (referenceHours !== 12) {
             referenceInSeconds = ((referenceHours + 12) * 3600) + (referenceMinutes * 60);
         } else {
             referenceInSeconds = (referenceHours * 3600) + (referenceMinutes * 60);
         }
    }
    //alert(inputId + " - " + inputInSeconds + " : " + referenceId + " - " + referenceInSeconds)
    var isValid = (inputInSeconds > referenceInSeconds);
    showMessage(isValid, inputElement, errorMsg, errorElement);//alert(isValid)
    return isValid;
}

// Return true if the input value is a valid email address
// (For illustration only. Should use regexe in production.)
function isValidEmail(inputId, errorMsg) {
    var inputElement = document.getElementById(inputId);
    var errorElement = document.getElementById(inputId + "Error");
    var inputValue = inputElement.value;
    var atPos = inputValue.indexOf("@");
    var dotPos = inputValue.lastIndexOf(".");
    var isValid = (atPos > 0) && (dotPos > atPos + 1) && (inputValue.length > dotPos + 2);
    showMessage(isValid, inputElement, errorMsg, errorElement);
    return isValid;
}

// Return true if selection is made (not default of "") in <select> input
function isSelected(inputId, errorMsg) {
    var inputElement = document.getElementById(inputId);
    var errorElement = document.getElementById(inputId + "Error");
    var inputValue = inputElement.value;
    // You need to set the default value of <select>'s <option> to "".
    var isValid = false;
    if ((inputValue !== "" && inputValue !== "0")) {
        isValid = true;
    }
    showMessage(isValid, inputElement, errorMsg, errorElement);
    return isValid;
}

// Return true if the one of the checkboxes or radio buttons is checked
function isChecked(inputName, errorMsg) {
    var inputElements = document.getElementsByName(inputName);
    var errorElement = document.getElementById(inputName + "Error");
    var isChecked = false;
    for (var i = 0; i < inputElements.length; i++) {
       if (inputElements[i].checked) {
          isChecked = true;  // found one element checked
          break;
       }
    }
    showMessage(isChecked, null, errorMsg, errorElement);
    return isChecked;
}

// Verify password. The password is kept in element with id "pwId".
// The verified password in id "verifiedPwId".
function verifyPassword(pwId, verifiedPwId, errorMsg) {
    var pwElement = document.getElementById(pwId);
    var verifiedPwElement = document.getElementById(verifiedPwId);
    var errorElement = document.getElementById(verifiedPwId + "Error");
    var isTheSame = (pwElement.value == verifiedPwElement.value);
    showMessage(isTheSame, verifiedPwElement, errorMsg, errorElement);
    return isTheSame;
}

// The verified captcha.
function verifyCaptcha(captcha, captchacode, errorMsg) {
    var pwElement = document.getElementById(captcha);
    var verifiedPwElement = document.getElementById(captchacode);
    var errorElement = document.getElementById(captchacode + "Error");
    var isTheSame = (pwElement.value == verifiedPwElement.value);
    showMessage(isTheSame, verifiedPwElement, errorMsg, errorElement);
    return isTheSame;
}

// Return true valid user name only letters, numbers and underscores
function isValidUser(inputId, errorMsg) {
    var inputElement = document.getElementById(inputId);
    var errorElement = document.getElementById(inputId + "Error");
    var inputValue = inputElement.value.trim();
    var isValid = inputValue.match(/^\w+$/);
    showMessage(isValid, inputElement, errorMsg, errorElement);
    return isValid;
}

// Return true Passwords must contain at least one number, one lowercase and one uppercase letter
function isValidPass(inputId, errorMsg) {
    var inputElement = document.getElementById(inputId);
    var errorElement = document.getElementById(inputId + "Error");
    var inputValue = inputElement.value.trim();
    var isValid = inputValue.match(/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/);
    showMessage(isValid, inputElement, errorMsg, errorElement);
    return isValid;
}

function isValidPercentage(inputId, errorMsg) {
    var inputElement = document.getElementById(inputId);
    var errorElement = document.getElementById(inputId + "Error");
    var inputValue = inputElement.value.trim();

    var inputPercentageBreakdown = inputValue.split(".");
    var wholeNumber = inputPercentageBreakdown[0];
    var wholeNumberLength = inputPercentageBreakdown[0].length;
    var decimalNumber = inputPercentageBreakdown[1];
    var decimalNumberLength = inputPercentageBreakdown[1].length;

    var isValid = false;

    if ((wholeNumber.search(/^[0-9]+$/) != -1) && (decimalNumber.search(/^[0-9]+$/) != -1)) {
        if (wholeNumber < 100 && wholeNumberLength <= 2 && decimalNumber <= 99 && decimalNumberLength <= 2) {
            isValid = true;
        } else if (wholeNumber == 100  && wholeNumberLength == 3 && decimalNumber == 00 && decimalNumberLength <= 2) {
            isValid = true;
        }
    }

    showMessage(isValid, inputElement, errorMsg, errorElement);
    return isValid;
}

function isValidPrice(inputId, errorMsg) {
    var inputElement = document.getElementById(inputId);
    var errorElement = document.getElementById(inputId + "Error");
    var inputValue = inputElement.value.trim();

    var inputPriceBreakdown = inputValue.split(".");
    var decimalNumber = parseInt(inputPriceBreakdown[1]);
    var decimalNumberLength = inputPriceBreakdown[1].length;

    var isValid = false;

    if ((inputPriceBreakdown[0].search(/^[0-9]+$/) != -1) && (inputPriceBreakdown[1].search(/^[0-9]+$/) != -1)) {
        if (decimalNumber <= 99 && decimalNumberLength <= 2) {
            isValid = true;
        }
    }

    showMessage(isValid, inputElement, errorMsg, errorElement);
    return isValid;
}

// The "onclick" handler for the "reset" button to clear the display
function clearDisplay() {
    var elms = document.getElementsByTagName("*");  // all tags
    for (var i = 0; i < elms.length; i++) {
         if ((elms[i].id).match(/Error$/)) {  // no endsWith() in JS?
            elms[i].innerHTML = "";
         }
         if (elms[i].className == "error") {  // assume only one class
            elms[i].className = "txt";
         }
    }
    // Set initial focus
    document.getElementById("name").focus();
}

//Show the error message on error
function showMessageForElement(inputId, errorMsg) {
    var inputElement = document.getElementById(inputId);
    var errorElement = document.getElementById(inputId + "Error");
    showMessage(false, inputElement, errorMsg, errorElement);
    return false;
}

//Hide the error message when there is no error
function hideMessageForElement(inputId, errorMsg) {
    var inputElement = document.getElementById(inputId);
    var errorElement = document.getElementById(inputId + "Error");
    showMessage(true, inputElement, errorMsg, errorElement);
    return true;
}

// Return true if ip address is valid
function isValidIPAddress(inputId, errorMsg) {
    var inputElement = document.getElementById(inputId);
    var errorElement = document.getElementById(inputId + "Error");
    var inputValue = inputElement.value.trim();
    var isValid = inputValue.match(/^(?:[0-9]{1,3}\.){3}[0-9]{1,3}$/);
    showMessage(isValid, inputElement, errorMsg, errorElement);
    return isValid;
}