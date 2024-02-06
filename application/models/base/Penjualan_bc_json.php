<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/date.func.php");

class Penjualan_json extends CI_Controller {

    function __construct() {
        parent::__construct();

        if($this->session->userdata("appuserid") == "")
        {
            redirect('login');
        }
    }

    function home(){
        $this->load->model('base-api/DataCombo');

        $bln = $this->input->get("bln");
        $thn = $this->input->get("thn");

        $arrdatabkn= [];
        $arrparam= ["vurl"=>"Penjualan?t=".$thn."&b=".$bln];
        $set= new DataCombo();
        $set->selectdata($arrparam, "", "allrow");
        $set= $set->rowResult;
        // print_r($set);exit;
        $arrPenjualan=$set['penjualan'];
        $textPenjualan='';
        for($i=0; $i<count($set['penjualan']);$i++){
            $persen=($arrPenjualan[$i]['realisasi']/$arrPenjualan[$i]['target'])*100;
            if($persen >= 100){
                $classBunder='fa fa-circle hijau';
            } else if($persen >= 95 && $persen < 100){
                $classBunder='fa fa-circle kuning';
            } else{
                $classBunder='fa fa-circle merah';
            }
            $textPenjualan .=
            "<div class='col-md-6 padding-none'>
                <div class='item'>
                    <div class='caption'>".$arrPenjualan[$i]['kategori']."</div>
                    <div class='title'>Realisasi</div>
                    <div class='nilai'>".numberformatnew($arrPenjualan[$i]['realisasi'])."</div>
                    <div class='title'>Target</div>
                    <div class='nilai'>".numberformatnew($arrPenjualan[$i]['target'])."</div>
                    <div class='persen'>
                        <i class='".$classBunder."' aria-hidden='true'></i>
                        <div class='nilai'>".numberformatnew($persen)."%</div>
                    </div>
                </div>
            </div>";
        }
        $result["textPenjualan"]= $textPenjualan;
        echo json_encode($result);
        exit;
    }

    function sub(){
        $this->load->model('base-api/DataCombo');

        $bln = $this->input->get("bln");
        $thn = $this->input->get("thn");
        
        $arrdatabkn= [];
        $arrparam= ["vurl"=>"Penjualan?t=".$thn."&b=".$bln];
        $set= new DataCombo();
        $set->selectdata($arrparam, "", "allrow");
        $set= $set->rowResult;
        // print_r($set);exit;
        $arrPenjualan=$set['penjualan'];
        $textPenjualan=array();
        for($i=0; $i<count($arrPenjualan);$i++){
            $persen=($arrPenjualan[$i]['realisasi']/$arrPenjualan[$i]['target'])*100;
            if($persen >= 100){
                $warna='#47ce6b';
            } else if($persen >= 95 && $persen < 100){
                $warna='#f6cd2f';
            } else{
                $warna='#ce3453';
            }
            $textPenjualan[$i]['Kategori']=$arrPenjualan[$i]['kategori'];
            $textPenjualan[$i]['target']=numberformatnew($arrPenjualan[$i]['target']);
            $textPenjualan[$i]['realisasi']=numberformatnew($arrPenjualan[$i]['realisasi']);
            $textPenjualan[$i]['warna']=$warna;
        }

        $arrPerbandingan=$set['perbandingan_penjualan'];
        $textPerbandingan=array();
        for($i=0; $i<count($arrPerbandingan);$i++){
            $persen=($arrPerbandingan[$i]['realisasi']/$arrPerbandingan[$i]['target'])*100;
            if($persen >= 100){
                $warna='#47ce6b';
            } else if($persen >= 95 && $persen < 100){
                $warna='#f6cd2f';
            } else{
                $warna='#ce3453';
            }
            $textPerbandingan[$i]['Kategori']=$arrPerbandingan[$i]['kategori'];
            $textPerbandingan[$i]['target']=numberformatnew($arrPerbandingan[$i]['target']);
            $textPerbandingan[$i]['realisasi']=numberformatnew($arrPerbandingan[$i]['realisasi']);
            $textPerbandingan[$i]['warna']=$warna;
        }
        $result["textPerbandingan"]= $textPerbandingan;
        $result["textPenjualan"]= $textPenjualan;
        echo json_encode($result);
        exit;
    }

}
?>