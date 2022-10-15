<form role="form" method="POST" id="kol_subscribe">
        <div class="subscribe_title">Анонсы скидок и акций</div>

        <input type="email" name="P_EMAIL" title="Введите email" class="input-text" required placeholder="Введите email...">
        <div class="form__group form__group_subs">
            <label class="label--checkbox">
                <input type="checkbox" name="form_text_28" value="1" required checked="checked">
                <p class="form_subs_agree">Подтверждаю согласие на обработку <a href="/information/politika-konfidentsialnosti.php">персональных данных</a>
                                <span class="req">*</span></p>
            </label>
        </div>
		<button type="submit" title="Подписаться" class="subscribe_button">Подписаться</button>
</form>

<script>
    document.getElementById('kol_subscribe').addEventListener('submit', function (evt) {
        var http = new XMLHttpRequest(), f = this;
        evt.preventDefault();
        http.open("POST", "/include/podp/contacts.php", true);
        http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        http.send("P_EMAIL=" + f.P_EMAIL.value);
        http.onreadystatechange = function () {
            if (http.readyState == 4 && http.status == 200) {
                if (YandexRG("podpiska"))
		{
                   setTimeout(function(){ document.location.replace("/subscribe/"); }, 500);
		}
            }
        }
        http.onerror = function () {
            alert('Извините, данные не были переданы');
        }
    }, false);
</script>

