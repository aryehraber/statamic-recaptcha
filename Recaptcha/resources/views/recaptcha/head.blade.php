@if ($hide_badge)
  <style>.grecaptcha-badge { visibility: collapse !important }</style>
@endif

@if ($invisible)
<script>
  var recaptchaCallback = function (form) {
    return function () {
      form.submit();
    }
  };

  document.addEventListener("DOMContentLoaded", function () {
    var captchas = Array.prototype.slice.call(document.querySelectorAll(".g-recaptcha[data-size=invisible]"), 0);

    captchas.forEach(function (captcha, index) {
      var form = captcha.parentNode;

      while (form.tagName !== "FORM") {
        form = form.parentNode;
      }

      // create custom callback
      window["recaptchaSubmit" + index] = recaptchaCallback(form);
      captcha.setAttribute("data-callback", "recaptchaSubmit" + index);

      form.addEventListener("submit", function (event) {
        event.preventDefault();
        grecaptcha.reset();
        grecaptcha.execute();
      });
    });
  });
</script>
@endif

<script src="{{ $url }}" async defer></script>
