**Модуль реализации API для обмена с системой LiteBox под формат API ecwid.**<br>
---------------------------------<br>
Особенности настройки при разворачивании 1СБитрикс:<br>
Проактивная защита -> Вкладка "Параметры" -> Настройка параметров контроля активности -> Увеличить количество хитов примерно до 1000 <br>
При установке выбирать php7 <br>
Кодировка для БД и админки utf-8<br>
<br>
Для настроек линеек необходимо выполнить настройку отображения торговых предложений: <br>
https://dev.1c-bitrix.ru/learning/course/?COURSE_ID=42&LESSON_ID=5260<br>
1) включаем режим правки https://prnt.sc/kmer0y<br>
2) переходим на страницу товара, открываем настройки компонента https://prnt.sc/kmepf2<br>
3) Параметры компонента -> Внешний вид -> Свойства для отбора предложений https://prnt.sc/kmepii<br>

В состав модуля входит комплексный компонент - реализация роутинга.<br>

Так же в компоненте реализована типизация данных - привидение полей объекта к типу заданному в документации(используется рефлексия).<br>

После установки модуля будет скопирована папка в корень проекта /api/ с подключением компонента<br>

API поддерживает версионность - так же обрабатывет компонент. **Необходимо обязательно передавать версию!**<br>

В компоненте заданы шаблоны адресов - в свойстве **defaultUrlTemplates** url будет автоматически распарсен и поместит значения переменые равные именам параметров.<br>

Заполнение данных происходит по шаблону - шаблоны лежат в модуле **/lib/lib/template**<br>

Важно! Чтобы заполнение сработало необходимо определить свойство **rule** где ключ - свойство объекта, значение поле из массива параметров(параметры передаются в конструктор).<br>
Так же необходимо унаследовать класс шаблона от **litebox\kassa\lib\Template\GenerateData** в нем определен конструктор, в котором реализовано заполнение объекта по правилам.<br>

 Для добавления нового метода необходимо создать класс в папаке **/lib/lib/methods/vN/** где N - версия апи<br>
 
 В классе необходимо создать один из двух методов **executeGET**/**executePOST** для get и post запроса соответственно.<br>
 
 В теле метода происходит получение и формирование всех необходиымых данных и заполнение объекта.
 Так же реализован базовый класс в который вынесены общие методы. <br>
 
 Для корректной работоспособности необходима лиценция Управление сайтом - **Бизнес**<br>
 Параметры разворачивания магазина - установить в utf-8
 
 При заливке на тест необходимо проверить конфиги, перекинуть весь битрикс на тест (сделать бекап теста lbmodule), dbconn и .settings.php и перекинуть локальную базу, на весь домен поставить права 777
 
 UPD: РЕГИСТР ПАПОК ВЛИЯЕТ НА РАБОТОСПОСОБНОСТЬ, ДОЛЖНЫ БЫТЬ НИЖНИЕ, 
 Проверка работоспособности:  domain/api/v1/token
 
 <br>
 Описание API размещено в папке _readme