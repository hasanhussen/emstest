<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'موقع المكتبة')</title>
    <style>
        /* تصميم الهيدر */
        /* تصميم الهيدر */
header {
    background-color: #007d65; /* اللون الأساسي */
    color: white;
    padding: 20px 0; /* إضافة مساحة فوق وتحت */
    position: relative; /* لتحريك العناصر بشكل مناسب */
}

/* الخط العريض أسفل الهيدر */
header::after {
    content: "";
    position: absolute;
    bottom: 0; /* وضع الخط العريض أسفل الهيدر */
    left: 0;
    width: 100%;
    height: 6px;
    background-color: #91704b; /* اللون العريض */
}

header .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 15px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative; /* لضبط العناصر داخل الحاوية */
    z-index: 1; /* لضمان بقاء العناصر فوق الخط العريض */
}

header .logo {
    display: flex;
    align-items: center;
}

header .logo img {
    height: 70px;
    width: 90px;
    margin-left: 10px;
}

header .menu-button {
    background-color: #91704b;
    color: white;
    border: none;
    border-radius: 5px;
    padding: 10px 15px;
    font-size: 16px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

header .menu-button img {
    max-height: 20px;
    margin-right: 8px;
}

header .menu-button:hover {
    background-color: #705234;
}

/* تصميم الفوتر */
footer {
    background-color: #444;
    color: #fff;
    padding: 20px 0;
    font-size: 14px;
}

footer .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 15px;
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
}

footer .column {
    width: 30%;
    margin-bottom: 15px;
}

footer .column h4 {
    margin-bottom: 10px;
    font-size: 16px;
    color: #f2f2f2;
}

footer ul {
    list-style: none;
    padding: 0;
}

footer ul li {
    margin-bottom: 8px;
}

footer ul li a {
    color: #f2f2f2;
    text-decoration: none;
}

footer ul li a:hover {
    text-decoration: underline;
}

footer .copyright {
    text-align: center;
    margin-top: 15px;
    color: #ccc;
}

/* إضافة اللوغو في الفوتر على اليسار */
footer .footer-logo {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    width: 100%;
}

footer .footer-logo img {
    max-height: 50px;
    margin-left: 10px;
}

    </style>
</head>
<body>
    <!-- الهيدر -->
    <header>
        <div class="container">
            <!-- زر القائمة (ثلاثة خطوط) -->
            <button class="menu-button">
                <div></div>
                <div></div>
                <div></div>
            </button>

            <!-- اللوغو -->
            <div class="logo">
            <img src="{{ asset('app-assets/img/جامعة1.png') }}" alt="شعار المكتبة">
            </div>
        </div>
    </header>

    <!-- المحتوى الرئيسي -->
    <div class="content">
        @yield('content')
    </div>
<!-- الفوتر -->
<footer>
    <div class="container">
        <!-- اللوغو في الفوتر على اليسار -->
        <div class="footer-logo">
        <!-- <img src="{{ asset('app-assets/img/جامعة1 .png') }}" alt="شعار المكتبة"> -->
        </div>

        <!-- العمود الأول -->
        <div class="column">
            <h4>اتصل بنا</h4>
            <ul>
                <li>المملكة العربية السعودية</li>
                <li>ص.ب 7572 الرياض 11472</li>
                <li>الهاتف: 0114186111</li>
                <li>الفاكس: 0114186222</li>
                <li>البريد الإلكتروني: info@kfnl.gov.sa</li>
            </ul>
        </div>
        <!-- العمود الثاني -->
        <div class="column">
            <h4>روابط مهمة</h4>
            <ul>
                <li><a href="#">خريطة الموقع</a></li>
                <li><a href="#">أسئلة شائعة</a></li>
                <li><a href="#">سياسة الخصوصية</a></li>
                <li><a href="#">اتفاقية الاستخدام</a></li>
            </ul>
        </div>
        <!-- العمود الثالث -->
        <div class="column">
            <h4>روابط إضافية</h4>
            <ul>
                <li><a href="#">التبليغ عن حادثة أمن معلومات</a></li>
                <li><a href="#">English</a></li>
            </ul>
        </div>
    </div>
    <div class="copyright">
        جميع الحقوق محفوظة لمكتبة الملك فهد الوطنية 2024
    </div>
</footer>

</body>
</html>
