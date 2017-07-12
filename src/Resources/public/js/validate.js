function ValidationForm(onSuccess, onFailure, onReset) {
    if (onSuccess) {
        this.onSuccess = onSuccess;
    } else {
        this.onSuccess = function (data) {
            console.log('success');
        }
    }

    if (onFailure) {
        this.onFailure = onFailure;
    } else {
        this.onFailure = function (data) {
            console.log('failure');
        }
    }

    if (onReset) {
        this.onReset = onReset;
    } else {
        this.onReset = function (context) {
            console.log('reset: ' + context);
        }
    }
}

ValidationForm.prototype.init = function (context) {
    if (!context) {
        context = 'body';
    }

    formHandler = this;

    $(context + ' input[data-validation-type]').on('change', function (e) {
        formHandler.validateInput(this);
    });
}

ValidationForm.prototype.reset = function (context) {
    if (!context) {
        context = 'body';
    }

    this.onReset(context);
}

ValidationForm.prototype.validateInput = function (element) {
    value = $(element).val();
    type = $(element).attr('data-validation-type');

    strict = !($(element).attr('data-validation-strict') == "false");

    id = $(element).attr('id');

    serviceUrl = Routing.generate('phm_labs_form_validator_validate');

    onSuccess = this.onSuccess;
    onFailure = this.onFailure;

    $.ajax({
        type: "POST",
        url: serviceUrl,
        data: {'value': value, 'type': type, 'element': id},
    })
        .done(function (data) {
            isValid = data['isValid'];
            if (isValid) {
                onSuccess(data, value, type, element);
            } else {
                onFailure(data, value, type, element, strict);
            }
        });
}
