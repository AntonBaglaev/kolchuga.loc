<form role="form" method="POST" id="kol_subscribe" class="form-subscribe">
<div class="subscribe_title">Анонсы скидок и новостей</div><div class="subscribe_body"><input type="email" name="P_EMAIL" title="E-mail" class="input-text" required placeholder="E-mail"><button type="submit" title="Подписаться" class="subscribe_button">Подписаться</button>
        </div>
        <div class="form__group form__group_subs">
            <label class="label--checkbox">
                <input type="checkbox" name="form_text_28" value="1" required checked="checked">
                <p class="form_subs_agree">Подтверждаю согласие на обработку <a href="/information/politika-konfidentsialnosti.php">персональных данных</a>
                                <span class="req">*</span></p>
            </label>
        </div>
</form>



<script>
    document.getElementById('kol_subscribe').addEventListener('submit', function (evt) {
        var http = new XMLHttpRequest(), f = this;
        evt.preventDefault();
        http.open("POST", "/include/podp-new/contacts.php", true);
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

