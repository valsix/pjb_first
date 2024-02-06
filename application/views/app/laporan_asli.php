
<style type="text/css">
    .zoom-loop {
        -webkit-animation: myzoom 0.3s;
        /* Safari 4.0 - 8.0 */
        animation: myzoom 0.3s;
        -webkit-animation-iteration-count: infinite;
        /* Safari 4.0 - 8.0 */
        animation-iteration-count: infinite;
        animation-direction: alternate;
        -webkit-animation-direction: alternate;
        /* Safari 4.0 - 8.0 */
    }

    .zoom-1 {
        -webkit-animation: myzooma 3s;
        /* Safari 4.0 - 8.0 */
        -webkit-animation-iteration-count: infinite;
        /* Safari 4.0 - 8.0 */
        animation: myzooma 3s;
        animation-iteration-count: infinite;
    }

    .zoom-2 {
        -webkit-animation: myzoomb 3s;
        /* Safari 4.0 - 8.0 */
        -webkit-animation-iteration-count: infinite;
        /* Safari 4.0 - 8.0 */
        animation: myzoomb 3s;
        animation-iteration-count: infinite;
    }

    .zoom-3 {
        -webkit-animation: myzoomz 3s;
        /* Safari 4.0 - 8.0 */
        -webkit-animation-iteration-count: infinite;
        /* Safari 4.0 - 8.0 */
        animation: myzoomz 3s;
        animation-iteration-count: infinite;
    }

    @-webkit-keyframes myzoom {
        0% {
            background-color: #666;
        }
        
        100% {
            background-color: #ccc;
        }
    }

    @keyframes myzoom {
        0% {
            background-color: #666;
        }
        
        100% {
            background-color: #ccc;
        }
    }

    @-webkit-keyframes myzooma {
        0% {
            background-color: #666;
            color: #fff;
        }
        
        11% {
            background-color: #ccc;
            color: #fff;
        }
        
        22% {
            background-color: #666;
            color: #fff;
        }
        
        33% {
            transform: scale(1);
        }
        
        44% {
            transform: scale(1);
        }
        
        55% {
            transform: scale(1);
        }
        
        66% {
            transform: scale(1);
        }
        
        100% {
            transform: scale(1);
        }
    }

    @keyframes myzooma {
        0% {
            background-color: #666;
            color: #fff;
        }
        
        11% {
            background-color: #ccc;
            color: #fff;
        }
        
        22% {
            background-color: #666;
            color: #fff;
        }
        
        33% {
            transform: scale(1);
        }
        
        44% {
            transform: scale(1);
        }
        
        55% {
            transform: scale(1);
        }
        
        66% {
            transform: scale(1);
        }
        
        100% {
            transform: scale(1);
        }
    }

    @-webkit-keyframes myzoomb {
        0% {
            transform: scale(1);
        }
        
        11% {
            background-color: #666;
            color: #fff;
        }
        
        22% {
            background-color: #ccc;
            color: #fff;
        }
        
        33% {
            background-color: #666;
            color: #fff;
        }
        
        44% {
            transform: scale(1);
        }
        
        55% {
            transform: scale(1);
        }
        
        66% {
            transform: scale(1);
        }
        
        100% {
            transform: scale(1);
        }
    }

    @keyframes myzoomb {
        0% {
            transform: scale(1);
        }
        
        11% {
            background-color: #666;
            color: #fff;
        }
        
        22% {
            background-color: #ccc;
            color: #fff;
        }
        
        33% {
            background-color: #666;
            color: #fff;
        }
        
        44% {
            transform: scale(1);
        }
        
        55% {
            transform: scale(1);
        }
        
        66% {
            transform: scale(1);
        }
        
        100% {
            transform: scale(1);
        }
    }

    @-webkit-keyframes myzoomz {
        0% {
            transform: scale(1);
        }
        
        11% {
            transform: scale(1);
        }
        
        22% {
            transform: scale(1);
        }
        
        33% {
            background-color: #666;
            color: #fff;
        }
        
        44% {
            transform: scale(1);
        }
        
        55% {
            transform: scale(1);
        }
        
        66% {
            transform: scale(1);
        }
        
        100% {
            transform: scale(1);
        }
    }

    @keyframes myzoomz {
        0% {
            transform: scale(1);
        }
        
        11% {
            transform: scale(1);
        }
        
        22% {
            transform: scale(1);
        }
        
        33% {
            background-color: #666;
            color: #fff;
        }
        
        44% {
            transform: scale(1);
        }
        
        55% {
            transform: scale(1);
        }
        
        66% {
            transform: scale(1);
        }
        
        100% {
            transform: scale(1);
        }
    }

    .tbmatrix {
        background-color: #fff;
    }

    .tbmatrix,
    .tbmatrix tr,
    .tbmatrix tr td,
    .tbmatrix tr th {
        border: 1px solid #9e9e9e;
        font-size: 11px;
        vertical-align: middle;
        padding: 5px;
        font-family: 'Lato', Arial, Tahoma, sans-serif !important;
    }

    .tbmatrix tr td div.zoom-loop {
        color: #000 !important;
    }
</style>
<div class="col-md-12">
    <div class="judul-halaman"> <?=$pgtitle?></div>
    <div class="body" style="padding: 15px 8px;">
        <div class="row">
            <div class="col-sm-12 col-lg-4 widthmtrix c-4" style="padding: 0px 7px !important; height: fit-content">
                <div style="text-align: center; margin-top: 10px;position: inherit; width:fit-content; margin: auto; height:fit-content">
                    <div id="divmatrix" style="text-align: left; width:500px;">
                        <table class="tbmatrix">
                            <tr>
                                <td rowspan='5' style='font-weight:bold;position:relative;width:25px'>
                                    <div style='position:absolute;right: 19px;top: 260px;width: 0px;-ms-transform: rotate(-90deg);-webkit-transform: rotate(-90deg);transform: rotate(-90deg);height: 0px;word-wrap: normal;'>TINGKAT&nbsp;KEMUNGKINAN
                                    </div>
                                </td>
                                <td align='center' style='width: 25px;text-align:center;vertical-align:middle;font-weight:bold'>Sangat Besar</td>
                                <td style='width: 25px;text-align:center;font-weight:bold;vertical-align:middle'>E</td>
                                <td class='bg-#2196f3' style='border:1px solid #555;background-color:#2196f3; padding:1px;' height='75px' width='75px' align='center' valign='middle'>
                                    <div style='position:relative;height:75px;width:75px; vertical-align:middle; text-align:center;padding:30px 0px;'>Moderat
                                        <div style='position:absolute;top:5px;right:5px;'></div>
                                    </div>
                                </td>
                                <td class='bg-#2196f3' style='border:1px solid #555;background-color:#2196f3; padding:1px;' height='75px' width='75px' align='center' valign='middle'>
                                    <div style='position:relative;height:75px;width:75px; vertical-align:middle; text-align:center;padding:30px 0px;'>Moderat
                                        <div style='position:absolute;top:5px;right:5px;'></div>
                                    </div>
                                </td>
                                <td class='bg-#ffe94d' style='border:1px solid #555;background-color:#ffe94d; padding:1px;border-left:7px dotted #000 !important;' height='75px' width='75px' align='center' valign='middle'>
                                    <div style='position:relative;height:75px;width:75px; vertical-align:middle; text-align:center;padding:30px 0px;'>Tinggi
                                        <div style='position:absolute;top:5px;right:5px;'></div>
                                    </div>
                                </td>
                                <td class='bg-#FF7F25' style='border:1px solid #555;background-color:#FF7F25; padding:1px;' height='75px' width='75px' align='center' valign='middle'>
                                    <div style='position:relative;height:75px;width:75px; vertical-align:middle; text-align:center;padding:30px 0px;'>Sangat Tinggi
                                        <div style='position:absolute;top:5px;right:5px;'>
                                            <div style='font-size: 10px;width:17px;height:17px;float:left;padding:1px;margin:2px;background-color:#fff;border:1px solid black;color:black;' class='dot'>1
                                            </div>
                                            <div style='font-size: 10px;width:17px;height:17px;float:left;padding:1px;margin:2px;background-color:#fff;border:1px solid black;color:black;' class='dot'>2
                                            </div>
                                            <div style='font-size: 10px;width:17px;height:17px;float:left;padding:1px;margin:2px;background-color:#fff;border:1px solid black;color:black;' class='dot'>3
                                            </div>
                                            <div style='font-size: 10px;width:17px;height:17px;float:left;padding:1px;margin:2px;background-color:#fff;border:1px solid black;color:black;' class='dot'>4
                                            </div>
                                            <div style='font-size: 10px;width:17px;height:17px;float:left;padding:1px;margin:2px;background-color:#fff;border:1px solid black;color:black;' class='dot'>5
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class='bg-#F14236' style='border:1px solid #555;background-color:#F14236; padding:1px;' height='75px' width='75px' align='center' valign='middle'>
                                    <div style='position:relative;height:75px;width:75px; vertical-align:middle; text-align:center;padding:30px 0px;'>Ekstrem
                                        <div style='position:absolute;top:5px;right:5px;'>
                                            <div style='font-size: 10px;width:17px;height:17px;float:left;padding:1px;margin:2px;background-color:#fff;border:1px solid black;color:black;' class='dot'>6
                                            </div>
                                            <div style='font-size: 10px;width:17px;height:17px;float:left;padding:1px;margin:2px;background-color:#666;border:1px solid black;color:#black;' class='dot zoom-loop'>1
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td align='center' style='width: 25px;text-align:center;vertical-align:middle;font-weight:bold'>Besar
                                </td>
                                <td style='width: 25px;text-align:center;font-weight:bold;vertical-align:middle'>D
                                </td>
                                <td class='bg-#58b051' style='border:1px solid #555;background-color:#58b051; padding:1px;' height='75px' width='75px' align='center' valign='middle'>
                                    <div style='position:relative;height:75px;width:75px; vertical-align:middle; text-align:center;padding:30px 0px;'>Rendah
                                        <div style='position:absolute;top:5px;right:5px;'></div>
                                    </div>
                                </td>
                                <td class='bg-#2196f3' style='border:1px solid #555;background-color:#2196f3; padding:1px;' height='75px' width='75px' align='center' valign='middle'>
                                    <div style='position:relative;height:75px;width:75px; vertical-align:middle; text-align:center;padding:30px 0px;'>Moderat
                                        <div style='position:absolute;top:5px;right:5px;'></div>
                                    </div>
                                </td>
                                <td class='bg-#ffe94d' style='border:1px solid #555;background-color:#ffe94d; padding:1px;border-left:7px dotted #000 !important;' height='75px' width='75px' align='center' valign='middle'>
                                    <div style='position:relative;height:75px;width:75px; vertical-align:middle; text-align:center;padding:30px 0px;'>Tinggi
                                        <div style='position:absolute;top:5px;right:5px;'>
                                            <div style='font-size: 10px;width:17px;height:17px;float:left;padding:1px;margin:2px;background-color:#666;border:1px solid black;color:#black;' class='dot zoom-loop'>7
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class='bg-#FF7F25' style='border:1px solid #555;background-color:#FF7F25; padding:1px;' height='75px' width='75px' align='center' valign='middle'>
                                    <div style='position:relative;height:75px;width:75px; vertical-align:middle; text-align:center;padding:30px 0px;'>Sangat Tinggi
                                        <div style='position:absolute;top:5px;right:5px;'>
                                            <div style='font-size: 10px;width:17px;height:17px;float:left;padding:1px;margin:2px;background-color:#fff;border:1px solid black;color:black;' class='dot'>7
                                            </div>
                                            <div style='font-size: 10px;width:17px;height:17px;float:left;padding:1px;margin:2px;background-color:#fff;border:1px solid black;color:black;' class='dot'>8
                                            </div>
                                            <div style='font-size: 10px;width:17px;height:17px;float:left;padding:1px;margin:2px;background-color:#fff;border:1px solid black;color:black;' class='dot'>9
                                            </div>
                                            <div style='font-size: 10px;width:17px;height:17px;float:left;padding:1px;margin:2px;background-color:#fff;border:1px solid black;color:black;' class='dot'>10
                                            </div>
                                            <div style='font-size: 10px;width:17px;height:17px;float:left;padding:1px;margin:2px;background-color:#666;border:1px solid black;color:#black;' class='dot zoom-loop'>2
                                            </div>
                                            <div style='font-size: 10px;width:17px;height:17px;float:left;padding:1px;margin:2px;background-color:#666;border:1px solid black;color:#black;' class='dot zoom-loop'>3
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class='bg-#F14236' style='border:1px solid #555;background-color:#F14236; padding:1px;' height='75px' width='75px' align='center' valign='middle'>
                                    <div style='position:relative;height:75px;width:75px; vertical-align:middle; text-align:center;padding:30px 0px;'>Ekstrem
                                        <div style='position:absolute;top:5px;right:5px;'></div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td align='center' style='width: 25px;text-align:center;vertical-align:middle;font-weight:bold'>Sedang</td><td style='width: 25px;text-align:center;font-weight:bold;vertical-align:middle'>C
                                </td>
                                <td class='bg-#58b051' style='border:1px solid #555;background-color:#58b051; padding:1px;' height='75px' width='75px' align='center' valign='middle'>
                                    <div style='position:relative;height:75px;width:75px; vertical-align:middle; text-align:center;padding:30px 0px;'>Rendah
                                    <div style='position:absolute;top:5px;right:5px;'></div></div>
                                </td>
                                <td class='bg-#2196f3' style='border:1px solid #555;background-color:#2196f3; padding:1px;' height='75px' width='75px' align='center' valign='middle'>
                                    <div style='position:relative;height:75px;width:75px; vertical-align:middle; text-align:center;padding:30px 0px;'>Moderat
                                        <div style='position:absolute;top:5px;right:5px;'>
                                        <div style='font-size: 10px;width:17px;height:17px;float:left;padding:1px;margin:2px;background-color:black;border:1px solid black;color:#fff;' class='dot'>1</div>
                                        <div style='font-size: 10px;width:17px;height:17px;float:left;padding:1px;margin:2px;background-color:black;border:1px solid black;color:#fff;' class='dot'>7
                                        </div>
                                        <div style='font-size: 10px;width:17px;height:17px;float:left;padding:1px;margin:2px;background-color:black;border:1px solid black;color:#fff;' class='dot'>9
                                        </div>
                                        <div style='font-size: 10px;width:17px;height:17px;float:left;padding:1px;margin:2px;background-color:black;border:1px solid black;color:#fff;' class='dot'>10</div>
                                        </div>
                                    </div>
                                </td>
                                <td class='bg-#ffe94d' style='border:1px solid #555;background-color:#ffe94d; padding:1px;border-left:7px dotted #000 !important;border-bottom:7px dotted #000 !important;' height='75px' width='75px' align='center' valign='middle'>
                                    <div style='position:relative;height:75px;width:75px; vertical-align:middle; text-align:center;padding:30px 0px;'>Tinggi
                                        <div style='position:absolute;top:5px;right:5px;'>
                                            <div style='font-size: 10px;width:17px;height:17px;float:left;padding:1px;margin:2px;background-color:#666;border:1px solid black;color:#black;' class='dot zoom-loop'>8
                                            </div>
                                            <div style='font-size: 10px;width:17px;height:17px;float:left;padding:1px;margin:2px;background-color:#666;border:1px solid black;color:#black;' class='dot zoom-loop'>9
                                            </div>
                                            <div style='font-size: 10px;width:17px;height:17px;float:left;padding:1px;margin:2px;background-color:#666;border:1px solid black;color:#black;' class='dot zoom-loop'>10
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class='bg-#ffe94d' style='border:1px solid #555;background-color:#ffe94d; padding:1px;' height='75px' width='75px' align='center' valign='middle'>
                                    <div style='position:relative;height:75px;width:75px; vertical-align:middle; text-align:center;padding:30px 0px;'>Tinggi
                                        <div style='position:absolute;top:5px;right:5px;'>
                                            <div style='font-size: 10px;width:17px;height:17px;float:left;padding:1px;margin:2px;background-color:#666;border:1px solid black;color:#black;' class='dot zoom-loop'>4
                                            </div>
                                            <div style='font-size: 10px;width:17px;height:17px;float:left;padding:1px;margin:2px;background-color:#666;border:1px solid black;color:#black;' class='dot zoom-loop'>5
                                            </div>
                                            <div style='font-size: 10px;width:17px;height:17px;float:left;padding:1px;margin:2px;background-color:#666;border:1px solid black;color:#black;' class='dot zoom-loop'>6
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class='bg-#FF7F25' style='border:1px solid #555;background-color:#FF7F25; padding:1px;' height='75px' width='75px' align='center' valign='middle'>
                                    <div style='position:relative;height:75px;width:75px; vertical-align:middle; text-align:center;padding:30px 0px;'>Sangat Tinggi
                                        <div style='position:absolute;top:5px;right:5px;'></div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td align='center' style='width: 25px;text-align:center;vertical-align:middle;font-weight:bold'>Kecil</td><td style='width: 25px;text-align:center;font-weight:bold;vertical-align:middle'>B
                                </td>
                                <td class='bg-#58b051' style='border:1px solid #555;background-color:#58b051; padding:1px;' height='75px' width='75px' align='center' valign='middle'>
                                    <div style='position:relative;height:75px;width:75px; vertical-align:middle; text-align:center;padding:30px 0px;'>Rendah
                                        <div style='position:absolute;top:5px;right:5px;'></div>
                                    </div>
                                </td>
                                <td class='bg-#58b051' style='border:1px solid #555;background-color:#58b051; padding:1px;' height='75px' width='75px' align='center' valign='middle'>
                                    <div style='position:relative;height:75px;width:75px; vertical-align:middle; text-align:center;padding:30px 0px;'>Rendah
                                        <div style='position:absolute;top:5px;right:5px;'></div>
                                    </div>
                                </td>
                                <td class='bg-#2196f3' style='border:1px solid #555;background-color:#2196f3; padding:1px;' height='75px' width='75px' align='center' valign='middle'>
                                    <div style='position:relative;height:75px;width:75px; vertical-align:middle; text-align:center;padding:30px 0px;'>Moderat
                                        <div style='position:absolute;top:5px;right:5px;'>
                                            <div style='font-size: 10px;width:17px;height:17px;float:left;padding:1px;margin:2px;background-color:black;border:1px solid black;color:#fff;' class='dot'>2
                                            </div>
                                            <div style='font-size: 10px;width:17px;height:17px;float:left;padding:1px;margin:2px;background-color:black;border:1px solid black;color:#fff;' class='dot'>3</div>
                                            <div style='font-size: 10px;width:17px;height:17px;float:left;padding:1px;margin:2px;background-color:black;border:1px solid black;color:#fff;' class='dot'>4</div>
                                            <div style='font-size: 10px;width:17px;height:17px;float:left;padding:1px;margin:2px;background-color:black;border:1px solid black;color:#fff;' class='dot'>5</div>
                                            <div style='font-size: 10px;width:17px;height:17px;float:left;padding:1px;margin:2px;background-color:black;border:1px solid black;color:#fff;' class='dot'>6</div>
                                            <div style='font-size: 10px;width:17px;height:17px;float:left;padding:1px;margin:2px;background-color:black;border:1px solid black;color:#fff;' class='dot'>8</div>
                                        </div>
                                    </div>
                                </td>
                                <td class='bg-#ffe94d' style='border:1px solid #555;background-color:#ffe94d; padding:1px;border-left:7px dotted #000 !important;' height='75px' width='75px' align='center' valign='middle'>
                                    <div style='position:relative;height:75px;width:75px; vertical-align:middle; text-align:center;padding:30px 0px;'>Tinggi
                                        <div style='position:absolute;top:5px;right:5px;'></div>
                                    </div>
                                </td>
                                <td class='bg-#FF7F25' style='border:1px solid #555;background-color:#FF7F25; padding:1px;' height='75px' width='75px' align='center' valign='middle'>
                                    <div style='position:relative;height:75px;width:75px; vertical-align:middle; text-align:center;padding:30px 0px;'>Sangat Tinggi
                                        <div style='position:absolute;top:5px;right:5px;'></div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td align='center' style='width: 25px;text-align:center;vertical-align:middle;font-weight:bold'>Sangat Kecil</td><td style='width: 25px;text-align:center;font-weight:bold;vertical-align:middle'>A
                                </td>
                                <td class='bg-#58b051' style='border:1px solid #555;background-color:#58b051; padding:1px;' height='75px' width='75px' align='center' valign='middle'>
                                    <div style='position:relative;height:75px;width:75px; vertical-align:middle; text-align:center;padding:30px 0px;'>Rendah
                                        <div style='position:absolute;top:5px;right:5px;'></div>
                                    </div>
                                </td>
                                <td class='bg-#58b051' style='border:1px solid #555;background-color:#58b051; padding:1px;' height='75px' width='75px' align='center' valign='middle'>
                                    <div style='position:relative;height:75px;width:75px; vertical-align:middle; text-align:center;padding:30px 0px;'>Rendah
                                        <div style='position:absolute;top:5px;right:5px;'></div>
                                    </div>
                                </td>
                                <td class='bg-#2196f3' style='border:1px solid #555;background-color:#2196f3; padding:1px;' height='75px' width='75px' align='center' valign='middle'>
                                    <div style='position:relative;height:75px;width:75px; vertical-align:middle; text-align:center;padding:30px 0px;'>Moderat
                                        <div style='position:absolute;top:5px;right:5px;'></div>
                                    </div>
                                </td>
                                <td class='bg-#ffe94d' style='border:1px solid #555;background-color:#ffe94d; padding:1px;border-left:7px dotted #000 !important;' height='75px' width='75px' align='center' valign='middle'>
                                    <div style='position:relative;height:75px;width:75px; vertical-align:middle; text-align:center;padding:30px 0px;'>Tinggi
                                        <div style='position:absolute;top:5px;right:5px;'></div>
                                    </div>
                                </td>
                                <td class='bg-#ffe94d' style='border:1px solid #555;background-color:#ffe94d; padding:1px;' height='75px' width='75px' align='center' valign='middle'>
                                    <div style='position:relative;height:75px;width:75px; vertical-align:middle; text-align:center;padding:30px 0px;'>Tinggi
                                        <div style='position:absolute;top:5px;right:5px;'></div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan='3' rowspan='3'></td>
                                <td style='font-weight:bold;text-align:center'>1</td>
                                <td style='font-weight:bold;text-align:center'>2</td>
                                <td style='font-weight:bold;text-align:center'>3</td>
                                <td style='font-weight:bold;text-align:center'>4</td>
                                <td style='font-weight:bold;text-align:center'>5</td>
                            </tr>
                            <tr>
                                <td style='font-weight:bold;text-align:center;vertical-align:middle'>Tidak Signifikan</td>
                                <td style='font-weight:bold;text-align:center;vertical-align:middle'>Minor
                                </td>
                                <td style='font-weight:bold;text-align:center;vertical-align:middle'>Medium</td>
                                <td style='font-weight:bold;text-align:center;vertical-align:middle'>Signifikan</td>
                                <td style='font-weight:bold;text-align:center;vertical-align:middle'>Sangat Signifikan</td>
                            </tr>
                            <tr>
                                <td colspan='5' style='font-weight:bold;text-align:center'>TINGKAT DAMPAK</td>
                            </tr> 
                        </table>        
                        <table style="width:auto;margin-top:10px;background:#fff">
                            <tbody>
                                <tr>
                                    <td style="width:100px;background-color:#fff;border:2px solid black;"></td>
                                    <td style="font-size: 12px;">&nbsp;RISIKO MELEKAT/AWAL</td>
                                </tr>

                                <tr>
                                    <td style="width:100px;background-color:#777;border:2px solid black;"></td>
                                    <td style="font-size: 12px">&nbsp;RISIKO AKTUAL/RISIKO RESIDU</td>
                                </tr>
                                <tr>
                                    <td style="width:100px;background-color:black;border:2px solid black;"></td>
                                    <td style="font-size: 12px">&nbsp;RISIKO TARGET</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
