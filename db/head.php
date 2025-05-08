<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">

<link rel="icon" href="assets/img/logo.png" type="image/x-icon">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link rel="stylesheet" href="assets/css/custom.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css"
    integrity="sha512-34s5cpvaNG3BknEWSuOncX28vz97bRI59UnVtEEpFX536A7BtZSJHsDyFoCl8S7Dt2TPzcrCEoHBGeM4SUBDBw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lilita+One&family=Bebas+Neue:wght@300..700&display=swap"
    rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">


<script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js"
    integrity="sha384-eI7PSr3L1XLISH8JdDII5YN/njoSsxfbrkCTnJrzXt+ENP5MOVBxD+l6sEG4zoLp"
    crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>


<script
    src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"></script>

<style>
    a,
    a:hover,
    a:focus {
        color: inherit;
        text-decoration: none;
        transition: all 0.3s;
    }

    .navbar {

        background: #fff;
        border: none;
        border-radius: 0;
        margin-bottom: 40px;
        box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
    }

    .navbar-btn {
        box-shadow: none;
        outline: none !important;
        border: none;
    }


    #sidebar {
        max-width: 250px;
        min-width: 250px;

        transition: all 1s;
        padding: 0;
    }

    #sidebar ul {
        padding: 0;
    }

    #sidebar ul li {
        list-style: none;
    }

    #sidebar ul li a {
        display: block;
        padding: 10px;
        text-decoration: none;
        font-size: 1.0.5em;
        transition: .5s;
    }

    #sidebar ul li a:hover {
        background: #7d543a;
        color: white;
    }

    #sidebar ul li a.active {
        background: #f6e8d0;
        color: #7d543a;
    }

    /* Default: Sidebar stays on the left */
    .main-content {
        flex-grow: 1;
        padding: 20px;
    }

    /* On smaller screens, sidebar goes above the content */
    @media (max-width: 768px) {

        #sidebar {
            width: 100%;
            max-width: none;
            min-width: 100%;
            margin-left: 0;
        }
    }

    .notification-bell {
        position: relative;
        display: inline-block;
    }

    .notification-bell .badge {
        position: absolute;
        top: -10px;
        right: -10px;
        padding: 5px 10px;
        border-radius: 50%;
        background-color: red;
        color: white;
        font-size: 0.5rem;
    }


    .avatar {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: brown;
        display: inline-flex;
        justify-content: center;
        align-items: center;
    }

    .avatar .bi-person-fill {
        font-size: 1.5rem;
        color: orange;
    }

    .gradient-bg {
        background: rgb(142, 91, 47);
        background: linear-gradient(125deg, rgba(142, 91, 47, 1) 0%, rgba(226, 169, 69, 1) 100%);
    }


    .datepicker {
        background-color: white;
        border-radius: 5px;
        box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.2);
        padding: 15px;
    }

    .datepicker-inline {
        width: auto !important;
    }

    .table-condensed tbody tr td {
        padding: 10px;
    }

    .masonry {
        margin: 0.5em auto;
        max-width: 768px;
        column-gap: 0.5em;
    }

    /* The Masonry Brick */
    .masonry-item {
        background: #fff;
        padding: 0.5em;
        margin: 0 0 0.5em;
    }

    /* Masonry on large screens */
    @media only screen and (min-width: 1024px) {
        .masonry {
            column-count: 4;
        }
    }

    /* Masonry on medium-sized screens */
    @media only screen and (max-width: 1023px) and (min-width: 768px) {
        .masonry {
            column-count: 3;
        }
    }

    /* Masonry on small screens */
    @media only screen and (max-width: 767px) and (min-width: 540px) {
        .masonry {
            column-count: 2;
        }
    }
</style>