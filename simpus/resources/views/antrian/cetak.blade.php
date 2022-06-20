{{-- <style>
    .card{position:relative;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column;min-width:0;word-wrap:break-word;background-color:#fff;background-clip:border-box;border:.125rem solid rgba(0,0,0,.125);border-radius:.5rem}.card>hr{margin-right:0;margin-left:0}.card>.list-group:first-child .list-group-item:first-child{border-top-left-radius:.5rem;border-top-right-radius:.5rem}.card>.list-group:last-child .list-group-item:last-child{border-bottom-right-radius:.5rem;border-bottom-left-radius:.5rem}.card-body{-webkit-box-flex:1;-ms-flex:1 1 auto;flex:1 1 auto;padding:1.25rem}.card-title{margin-bottom:.75rem}.card-subtitle{margin-top:-.375rem;margin-bottom:0}.card-text:last-child{margin-bottom:0}.card-link:hover{text-decoration:none}.card-link+.card-link{margin-left:1.25rem}.card-header{padding:.75rem 1.25rem;margin-bottom:0;background-color:rgba(0,0,0,.03);border-bottom:.125rem solid rgba(0,0,0,.125)}.card-header:first-child{border-radius:calc(.5rem - .125rem) calc(.5rem - .125rem) 0 0}.card-header+.list-group .list-group-item:first-child{border-top:0}.card-footer{padding:.75rem 1.25rem;background-color:rgba(0,0,0,.03);border-top:.125rem solid rgba(0,0,0,.125)}.card-footer:last-child{border-radius:0 0 calc(.5rem - .125rem) calc(.5rem - .125rem)}.card-header-tabs{margin-right:-.625rem;margin-bottom:-.75rem;margin-left:-.625rem;border-bottom:0}.card-header-pills{margin-right:-.625rem;margin-left:-.625rem}.card-img-overlay{position:absolute;top:0;right:0;bottom:0;left:0;padding:1.25rem}.card-img{width:100%;border-radius:calc(.5rem - .125rem)}.card-img-top{width:100%;border-top-left-radius:calc(.5rem - .125rem);border-top-right-radius:calc(.5rem - .125rem)}.card-img-bottom{width:100%;border-bottom-right-radius:calc(.5rem - .125rem);border-bottom-left-radius:calc(.5rem - .125rem)}.card-deck{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column}.card-deck .card{margin-bottom:15px}@media (min-width:576px){.card-deck{-webkit-box-orient:horizontal;-webkit-box-direction:normal;-ms-flex-flow:row wrap;flex-flow:row wrap;margin-right:-15px;margin-left:-15px}.card-deck .card{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-flex:1;-ms-flex:1 0 0%;flex:1 0 0%;-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column;margin-right:15px;margin-bottom:0;margin-left:15px}}.card-group{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column}.card-group>.card{margin-bottom:15px}@media (min-width:576px){.card-group{-webkit-box-orient:horizontal;-webkit-box-direction:normal;-ms-flex-flow:row wrap;flex-flow:row wrap}.card-group>.card{-webkit-box-flex:1;-ms-flex:1 0 0%;flex:1 0 0%;margin-bottom:0}.card-group>.card+.card{margin-left:0;border-left:0}.card-group>.card:not(:last-child){border-top-right-radius:0;border-bottom-right-radius:0}.card-group>.card:not(:last-child) .card-header,.card-group>.card:not(:last-child) .card-img-top{border-top-right-radius:0}.card-group>.card:not(:last-child) .card-footer,.card-group>.card:not(:last-child) .card-img-bottom{border-bottom-right-radius:0}.card-group>.card:not(:first-child){border-top-left-radius:0;border-bottom-left-radius:0}.card-group>.card:not(:first-child) .card-header,.card-group>.card:not(:first-child) .card-img-top{border-top-left-radius:0}.card-group>.card:not(:first-child) .card-footer,.card-group>.card:not(:first-child) .card-img-bottom{border-bottom-left-radius:0}}.card-columns .card{margin-bottom:.75rem}@media (min-width:576px){.card-columns{-webkit-column-count:3;-moz-column-count:3;column-count:3;-webkit-column-gap:1.25rem;-moz-column-gap:1.25rem;column-gap:1.25rem;orphans:1;widows:1}.card-columns .card{display:inline-block;width:100%}}.accordion>.card{overflow:hidden}.accordion>.card:not(:first-of-type) .card-header:first-child{border-radius:0}.accordion>.card:not(:first-of-type):not(:last-of-type){border-bottom:0;border-radius:0}.accordion>.card:first-of-type{border-bottom:0;border-bottom-right-radius:0;border-bottom-left-radius:0}.accordion>.card:last-of-type{border-top-left-radius:0;border-top-right-radius:0}.accordion>.card .card-header{margin-bottom:-.125rem}

    h1, h2, h3{
       font-family: Montserrat,-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
       line-height: 1.2;
    }
    h1{
        font-size: 1.6rem;
    }
    h2{
        font-size: 1rem;
    }
</style>
<div class ="card" style="width: 18rem; border-radius:0.5rem 0.5rem 0 0">
    <center>
        <h1 style="margin-bottom: 0">SELAMAT DATANG</h1>
        <h2 style="margin-top:5px">Di Puskesmas Jepang</h2>
    </center>

</div>
<div class ="card" style="width: 18rem; border-radius:0rem;border-top:0">
<p style="margin-bottom: 0; margin-left:5px">{{ date('d-m-Y', strtotime(\Carbon\Carbon::now())) }}</p>
    <center>
        <h1 style="margin-top:0px; margin-bottom:5px">ANTRIAN</h1>
        <h1 style="margin-top:5px; margin-bottom:5px">{{ $antrian['no_antrian'] }}</h1>
        <h3 style="margin-top:5px; margin-bottom:5px">{{ $antrian['poli'] }}</h3>
    </center>
</div>
<div class ="card" style="width: 18rem; border-radius:0 0 0.5rem 0.5rem; border-top:0;">
    <center>
        <h1>TERIMAKASIH</h1>
    </center>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        window.print();
        window.onafterprint = function(){ setTimeout(function () { window.close(); }, 500);};
    });
</script>

 --}}
 <!DOCTYPE html>
 <html lang="en">
     <head>
         <meta charset="UTF-8">
         <meta name="viewport" content="width=device-width, initial-scale=1.0">
         <meta http-equiv="X-UA-Compatible" content="ie=edge">
         <link rel="stylesheet" href="style.css">
         <title>Cetak Antrian</title>
         <style>
             * {
                    font-size: 12px;
                    font-family: Montserrat,-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
                    line-height: 1.4;
                }

                td,
                th,
                tr,
                table {
                    border-top: 0px solid black;
                    border-collapse: collapse;
                    border-radius: 1em;
                }

                td.description,
                th.description {
                    width: 75px;
                    max-width: 75px;
                }

                td.quantity,
                th.quantity {
                    width: 40px;
                    max-width: 40px;
                    word-break: break-all;
                }

                td.price,
                th.price {
                    width: 40px;
                    max-width: 40px;
                    word-break: break-all;
                }

                .centered {
                    text-align: center;
                    align-content: center;
                }

                .ticket {
                    width: 155px;
                    max-width: 155px;
                }

                img {
                    max-width: inherit;
                    width: inherit;
                }

                .thead{
                    border: 1px solid black;
                    border-left: 1px solid black;
                    border-right: 1px solid black;
                    border-radius: 1em;
                }
                /* table{
                    border-radius: 1em;
                } */
                .tbody{
                    border-top: 1px solid black;
                    border-left: 1px solid black;
                    border-right: 1px solid black;
                }
                .tfoot{
                    border-top: 1px solid black;
                    border-bottom: 1px solid black;
                    border-left: 1px solid black;
                    border-right: 1px solid black;
                }
                h1{
                    line-height: 0.4rem;
                }

                @media print {
                    .hidden-print,
                    .hidden-print * {
                        display: none !important;
                    }
                }
         </style>
     </head>
     <body>
         <div class="ticket">
             <table border="0">
                 <thead class="thead">
                     <tr>
                         <th colspan="3"><h1>SELAMAT DATANG</h1></th>
                     </tr>
                     <tr>

                         <th colspan="3">Di Puskesmas Jepang</th>

                     </tr>
                 </thead>
                 <tbody class="tbody">
                     <tr>
                        <td colspan="3">{{ date('d-m-Y', strtotime(\Carbon\Carbon::now())) }}</td>
                     </tr>
                     <tr>
                        <td colspan="3" class="centered"><h1>ANTRIAN</h1></td>
                     </tr>
                     <tr>
                         <td colspan="3" class="centered"><h1>{{ $antrian['no_antrian'] }}</h1></td>
                     </tr>
                     <tr>
                         <td colspan="3" class="centered"><h1>{{ $antrian['poli'] }}</h1></td>
                     </tr>
                     <tr>
                         <td class="quantity"></td>
                         <td class="description"></td>
                         <td class="price"></td>
                     </tr>


                 </tbody>
                 <tfoot>
                     <tr style="border-top: 1px solid black; border-right:1px solid black; border-left:1px solid black">
                         <td colspan="3" class="centered"><h1>TERIMAKASIH</h1></td>
                     </tr>
                     <tr style="border-top:1px solid black;">
                         <td colspan="3">&nbsp;</td>
                     </tr>
                     <tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                 </tfoot>
             </table>
             <br><br><br><br><br>

         </div>

     </body>
     {{-- <script>
         const $btnPrint = document.querySelector("#btnPrint");
        $btnPrint.addEventListener("click", () => {
            window.print();
        });
     </script> --}}
     <script>
        document.addEventListener("DOMContentLoaded", function() {
            window.print();
            window.onafterprint = function(){ setTimeout(function () { window.close(); }, 500);};
        });
    </script>
 </html>
