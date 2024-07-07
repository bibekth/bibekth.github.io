<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mero Pasal</title>

    {{-- Bootstrap CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

    {{-- Bootstrap Icon --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- Google Fonts --}}
    <link
        href="https://fonts.googleapis.com/css?family=Abel|Abril+Fatface|Acme|Alegreya|Alegreya+Sans|Anton|Archivo|Archivo+Black|Archivo+Narrow|Arimo|Arvo|Asap|Asap+Condensed|Bitter|Bowlby+One+SC|Bree+Serif|Cabin|Cairo|Catamaran|Crete+Round|Crimson+Text|Cuprum|Dancing+Script|Dosis|Droid+Sans|Droid+Serif|EB+Garamond|Exo|Exo+2|Faustina|Fira+Sans|Fjalla+One|Francois+One|Gloria+Hallelujah|Hind|Inconsolata|Indie+Flower|Josefin+Sans|Julee|Karla|Lato|Libre+Baskerville|Libre+Franklin|Lobster|Lora|Mada|Manuale|Maven+Pro|Merriweather|Merriweather+Sans|Montserrat|Montserrat+Subrayada|Mukta+Vaani|Muli|Noto+Sans|Noto+Serif|Nunito|Open+Sans|Open+Sans+Condensed:300|Oswald|Oxygen|PT+Sans|PT+Sans+Caption|PT+Sans+Narrow|PT+Serif|Pacifico|Passion+One|Pathway+Gothic+One|Play|Playfair+Display|Poppins|Questrial|Quicksand|Raleway|Roboto|Roboto+Condensed|Roboto+Mono|Roboto+Slab|Ropa+Sans|Rubik|Saira|Saira+Condensed|Saira+Extra+Condensed|Saira+Semi+Condensed|Sedgwick+Ave|Sedgwick+Ave+Display|Shadows+Into+Light|Signika|Slabo+27px|Source+Code+Pro|Source+Sans+Pro|Spectral|Titillium+Web|Ubuntu|Ubuntu+Condensed|Varela+Round|Vollkorn|Work+Sans|Yanone+Kaffeesatz|Zilla+Slab|Zilla+Slab+Highlight"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>

<body>
    <div class="body">
        <div class="container">
            <div class="nav-section">
                <div class="row">
                    <div class="col-1">
                        <div class="logo-section">
                            <a href="{{ route('home') }}">
                                meropasal
                            </a>
                        </div>
                    </div>
                    <div class="col-10">
                        <div class="navigations">
                            <ul class="row">
                                <li class="col-4">
                                    <div class="nav-title">
                                        <a href="#home">Home</a>
                                    </div>
                                </li>
                                <li class="col-4">
                                    <div class="nav-title">
                                        <a href="#contact_us">Contact Us</a>
                                    </div>
                                </li>
                                <li class="col-4">
                                    <div class="nav-title" style="border: none">
                                        <a href="#about_us">About Us</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-1 d-flex justify-content-end">
                        <div class="profile">
                            Profile
                        </div>
                    </div>
                </div>
            </div>
            <div class="body-section">
                A form to make a request to be a part of mero pasal for the vendors.
            </div>
            <div class="footer-section">

            </div>
        </div>
    </div>
</body>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'poppins', 'sans-serif';
        color: #1f1f1f;
    }

    body {
        background-color: #ccc;
    }

    .body {
        background-color: #eaeaea;
    }

    a {
        text-decoration: none;
        color: inherit;
    }

    .nav-section{
        align-content: center;
    }

    .navigations ul li{
        list-style: none;
    }

    .nav-title{
        display: flex;
        justify-content: center;
        border-right: 1px solid black;
    }


</style>

</html>
