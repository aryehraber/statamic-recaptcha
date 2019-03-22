@if ($hide_badge)
  <style>.grecaptcha-badge { visibility: collapse !important }</style>
@endif

<script>
  var recaptchaCallback = function (form) {
    return function () {
      form.submit();
    }
  };

  document.addEventListener("DOMContentLoaded", function () {
    var captchas = Array.prototype.slice.call(document.querySelectorAll(".g-recaptcha[data-size=invisible]"), 0);

    var formId = 0;
    captchas.forEach(function (captcha) {
      ++formId;
      var form = captcha.parentNode;
      while (form.tagName !== "FORM") {
        form = form.parentNode;
      }

      // create custom callback
      window["recaptchaSubmit" + formId] = recaptchaCallback(form);
      captcha.setAttribute("data-callback", "recaptchaSubmit" + formId);

      form.addEventListener("submit", function (event) {
        event.preventDefault();
        grecaptcha.reset();
        grecaptcha.execute();
      });
    });
  });
</script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
