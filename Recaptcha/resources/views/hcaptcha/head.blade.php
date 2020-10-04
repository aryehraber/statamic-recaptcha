@if ($invisible)
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var captchas = Array.prototype.slice.call(document.querySelectorAll('.h-captcha[data-size=invisible]'), 0);

    captchas.forEach(function (captcha, index) {
      var form = captcha.parentNode;
      while (form.tagName !== 'FORM') {
        form = form.parentNode;
      }

      // create custom callback
      window['hcaptchaSubmit' + index] = function () { form.submit(); };
      captcha.setAttribute('data-callback', 'hcaptchaSubmit' + index);

      form.addEventListener('submit', function (event) {
        event.preventDefault();
        hcaptcha.reset(index);
        hcaptcha.execute(index);
      });
    });
  });
</script>
@endif

<script src="{{ $url }}" async defer></script>
