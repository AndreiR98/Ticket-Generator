<?php
    use App\Http\Controllers\GenerateQR;

    
    $from_array = [
        'BU'=>'Bucuresti',
        'SV'=>'Suceava',
        'TM'=>'Timisoara',
        'PT'=>'Pitesti',
        'SM'=>'Satul mare',
        'IS'=>'Iasi',
        'CZ'=>'Cazanesti'
    ];
?>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Ticket - Generator</title>

        <!-- Scripts -->
       

        
        <script src="{{asset('/js/qrcode.js')}}"></script>
        <script src="{{asset('/js/qrcode.min.js')}}"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>

         <script type="text/javascript">
            jQuery(function($) {
                $("#datepicker").datetimepicker();
                if($("#datepicker") != null){
                    $("#arrivalTime").html($("#datepicker").val());
                }
            });
        </script>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css" />
        <style>
            /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}a{background-color:transparent}[hidden]{display:none}html{font-family:system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;line-height:1.5}*,:after,:before{box-sizing:border-box;border:0 solid #e2e8f0}a{color:inherit;text-decoration:inherit}svg,video{display:block;vertical-align:middle}video{max-width:100%;height:auto}.bg-white{--bg-opacity:1;background-color:#fff;background-color:rgba(255,255,255,var(--bg-opacity))}.bg-gray-100{--bg-opacity:1;background-color:#f7fafc;background-color:rgba(247,250,252,var(--bg-opacity))}.border-gray-200{--border-opacity:1;border-color:#edf2f7;border-color:rgba(237,242,247,var(--border-opacity))}.border-t{border-top-width:1px}.flex{display:flex}.grid{display:grid}.hidden{display:none}.items-center{align-items:center}.justify-center{justify-content:center}.font-semibold{font-weight:600}.h-5{height:1.25rem}.h-8{height:2rem}.h-16{height:4rem}.text-sm{font-size:.875rem}.text-lg{font-size:1.125rem}.leading-7{line-height:1.75rem}.mx-auto{margin-left:auto;margin-right:auto}.ml-1{margin-left:.25rem}.mt-2{margin-top:.5rem}.mr-2{margin-right:.5rem}.ml-2{margin-left:.5rem}.mt-4{margin-top:1rem}.ml-4{margin-left:1rem}.mt-8{margin-top:2rem}.ml-12{margin-left:3rem}.-mt-px{margin-top:-1px}.max-w-6xl{max-width:72rem}.min-h-screen{min-height:100vh}.overflow-hidden{overflow:hidden}.p-6{padding:1.5rem}.py-4{padding-top:1rem;padding-bottom:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.pt-8{padding-top:2rem}.fixed{position:fixed}.relative{position:relative}.top-20{top:20px;}.right-0{right:0}.shadow{box-shadow:0 1px 3px 0 rgba(0,0,0,.1),0 1px 2px 0 rgba(0,0,0,.06)}.text-center{text-align:center}.top-50{top:50px;}.text-gray-200{--text-opacity:1;color:#edf2f7;color:rgba(237,242,247,var(--text-opacity))}.text-gray-300{--text-opacity:1;color:#e2e8f0;color:rgba(226,232,240,var(--text-opacity))}.text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}.text-gray-500{--text-opacity:1;color:#a0aec0;color:rgba(160,174,192,var(--text-opacity))}.text-gray-600{--text-opacity:1;color:#718096;color:rgba(113,128,150,var(--text-opacity))}.text-gray-700{--text-opacity:1;color:#4a5568;color:rgba(74,85,104,var(--text-opacity))}.text-gray-900{--text-opacity:1;color:#1a202c;color:rgba(26,32,44,var(--text-opacity))}.underline{text-decoration:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.w-5{width:1.25rem}.w-8{width:2rem}.w-auto{width:auto}.grid-cols-1{grid-template-columns:repeat(1,minmax(0,1fr))}@media (min-width:640px){.sm\:rounded-lg{border-radius:.5rem}.sm\:block{display:block}.sm\:items-center{align-items:center}.sm\:justify-start{justify-content:flex-start}.sm\:justify-between{justify-content:space-between}.sm\:h-20{height:5rem}.sm\:ml-0{margin-left:0}.sm\:px-6{padding-left:1.5rem;padding-right:1.5rem}.sm\:pt-0{padding-top:0}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width:768px){.md\:border-t-0{border-top-width:0}.md\:border-l{border-left-width:1px}.md\:grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}}@media (min-width:1024px){.lg\:px-8{padding-left:2rem;padding-right:2rem}}@media (prefers-color-scheme:dark){.dark\:bg-gray-800{--bg-opacity:1;background-color:#2d3748;background-color:rgba(45,55,72,var(--bg-opacity))}.dark\:bg-gray-900{--bg-opacity:1;background-color:#1a202c;background-color:rgba(26,32,44,var(--bg-opacity))}.dark\:border-gray-700{--border-opacity:1;border-color:#4a5568;border-color:rgba(74,85,104,var(--border-opacity))}.dark\:text-white{--text-opacity:1;color:#fff;color:rgba(255,255,255,var(--text-opacity))}.dark\:text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}.dark\:text-gray-500{--tw-text-opacity:1;color:#6b7280;color:rgba(107,114,128,var(--tw-text-opacity))}}
        </style>

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased">

        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
                <div class="hidden fixed top-20 px-6 py-4 sm:block">
                        <a href="{{url('/')}}" class="text-lg text-gray-800 dark:text-gray-500 underline">Index</a> - 
                        <a href="{{url('/scan')}}" class="text-lg text-gray-800 dark:text-gray-500 underline">Scan QR Ticket</a>
                </div>

                <div class="fixed top-0 alert alert-danger print-error-msg" style="display:none">
                    <ul></ul>
                </div>

                <form>
                    @csrf
                    <h1>Ticket QR Generator</h1>
                    <table class="table table-striped">
                        <tr>
                            <th><strong>Train:</strong></th>
                            <th><strong>Ticket</strong></th>
                        </tr>
                        <tr>
                            <td>Departure time:<input type='text' name='JSONDeparture' id='datepicker' placeholder="Choose Date and Time" class='hadDatepicker'></td>
                            <td><label>Train ID:</label>
                                <select id="JSONTrain">
                                    <option value="IR-7707">IR-7707</option>
                                    <option value="IR-1781">IR-1781</option>
                                    <option value="R-E-9033">R-E-9033</option>
                                    <option value="IRN-1765">IRN-1765</option>
                                    <option value="R-5602">R-5602</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><label>Signing KEY:</label>
                                <select id="KID" name="KID">
                                    <option value="94d7829cc75c2029">94d7829cc75c2029</option>
                                    <option value="d51dabbd92ce6670">d51dabbd92ce6670</option>
                                    <option value="1707d891c317627c">1707d891c317627c(FAKE KEY)</option>
                                </select>
                            </td>
                            <td><label>Class:</label><select id='JSONClass'>
                                <option value="1">Class 1</option>
                                <option value="2">Class 2</option>
                            </select></td>
                        </tr>
                        <tr>
                            <td><label>From:</label>
                                <select id='JSONFrom'>
                                    @foreach($from_array as $id=>$from)
                                    <option value="{{$id}}">{{$from}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td><label>Car:</label>
                                <select id='JSONCar'>
                                    @for($i = 1; $i<=10; $i++)
                                    <option value="{{$i}}">Car #{{$i}}</option>
                                    @endfor
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><label>To:</label>
                                <select id='JSONTo'>
                                    @foreach($from_array as $id=>$from)
                                    <option value="{{$id}}">{{$from}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td><label>Seat:</label>
                                <select id='JSONSeat'>
                                    @for($i = 1; $i<=50; $i++)
                                    <option value="{{$i}}">Seat #{{$i}}</option>
                                    @endfor
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Familly name:</label><input type='text' id='fname' name='Familly name' placeholder="Familly Name"></th>
                            <th><label>Names:</label><input type='text' id='sname' name='Surname' placeholder="Name"></th>
                        </tr>
                        <tr>
                            <th colspan="2"><button type="button" class="btn-submit btn-primary">Confirm</button></th>
                        </tr>
                        <tr>
                            <td>
                                <div id="QRCODE" style="text-align: center;"></div>
                            </td>
                            <td>
                                <div id="QR_DATA"></div>
                            </td>
                        </tr>
                    </table>
                </form>
        </div>

        <script type="text/javascript">
            $(document).ready(function() {
                $(".btn-submit").click(function(e){
                    e.preventDefault();

                    var _token = $("input[name='_token']").val();
                    var departure_time = $("input[name='JSONDeparture']").val();
                    var key = $("#KID").val();
                    var from = $("#JSONFrom").val();
                    var to = $("#JSONTo").val();
                    var trainID = $("#JSONTrain").val();
                    var cl = $("#JSONClass").val();
                    var car = $("#JSONCar").val();
                    var seat = $("#JSONSeat").val();

                    var fname = $("#fname").val();
                    var sname = $("#sname").val();

                    $.ajax({
                        url:"{{route('qr.form')}}",
                        type:'POST',
                        data:{
                            _token:_token,
                            departure_time:departure_time,
                            key:key,
                            from:from,
                            to:to,
                            trainID:trainID,
                            cl:cl,
                            car:car,
                            seat:seat,
                            fname:fname,
                            sname:sname
                        },
                        success:function(data){
                            if($.isEmptyObject(data.error)){
                                $("#QRCODE").html("<img src='"+data.QR+"' width=400 height=400 name='"+data.ID+"'>");
                                $("#QR_DATA").html("<tr><td><label>ID:"+data.ID+"</label></td></tr><tr><td><label>Valid until:<strong>"+convertUnix(data.Valid)+"</strong></label></td></tr>");
                                //$("#QRCODE").html(data.QR);
                            }else{
                                printErrorMsg(data.error);
                            }
                        }
                    });
                });

                function printErrorMsg(msg) {
                    $(".print-error-msg").find("ul").html('');
                    $(".print-error-msg").css('display', 'block');
                    $.each(msg, function(key, value) {
                        $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                    });
                }

                function convertUnix(timestamp){
                    var date = new Date(timestamp * 1000);

                    return ""+date.getDate()+
                           "/"+(date.getMonth()+1)+
                           "/"+date.getFullYear()+
                           " "+date.getHours()+
                           ":"+date.getMinutes()+
                           ":"+date.getSeconds();
                    
                }
            });
        </script>
        
    </body>
</html>