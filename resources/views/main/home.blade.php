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
    <div class="container">
        <div class="under-construction" style="height: 100vh;">
            <span class="h1 col-12 d-flex justify-content-center" id="mero_pasal_org">MERO PASAL ORGANIZATION</span>
            <span class="h3 col-12 d-flex justify-content-center">Under Construction</span>
            <span class="h6 col-12 d-flex justify-content-center">All rights are owned by &nbsp;<strong> BIBEK THAPA MAGAR</strong></span>
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

    #mero_pasal_org {
        font-family: Montserrat;
        font-weight: 900;
        color: red;
    }

    .under-construction {
        align-content: center;
        background: linear-gradient(to right, #0014c7, #ff0000);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: rotateText 10s ease-in-out infinite;
    }

    @keyframes rotateText {
        0% {
            transform: rotateY(0deg);
            /* transform: rotateX(0deg); */
            /* Start rotation */
        }

        50%{
            transform: rotateY(180deg);
            /* transform: rotateX(180deg); */
        }

        100% {
            transform: rotateY(360deg);
            /* transform: rotateX(360deg); */
            /* End rotation after 360 degrees */
        }
    }

    .body {
        background-color: #eaeaea;
    }

    a {
        text-decoration: none;
        color: inherit;
    }

    .nav-section {
        align-content: center;
    }

    .navigations ul li {
        list-style: none;
    }

    .nav-title {
        display: flex;
        justify-content: center;
        border-right: 1px solid black;
    }
</style>

</html>
