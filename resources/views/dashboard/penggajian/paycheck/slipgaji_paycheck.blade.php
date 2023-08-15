<!DOCTYPE html>
<html lang="id">
<head>
    <title>Payroll Saloka Park </title>
    <link rel="stylesheet" href="{{ public_path('assets/pdf/portrait.css') }}">
</head>

<body>
<header>
    <table style="width: 100%">
        <tr>
            <td rowspan="5" style="width: 20%">
                <!-- <img src="{{ public_path('images/logoPIP.png') }}" class="logo" alt="Logo"> -->
            </td>
          
            <td class="header-tj" style="width: 60%">SLIP GAJI</td>
            <td rowspan="5"></td>
        </tr>
        <tr>
            <td class="text-bold">PT. PANORAMA INDAH PERMAI</td>
        </tr>
        <tr>
            <td class="text-bold">Saloka Theme Park - Jl. Fatmawati No. 154.</td>
        </tr>
        <tr>
            <td class="text-bold">Kel. Lopait - Kec. Tuntang, Kab. Semarang</td>
        </tr>
        <tr>
            <td class="text-bold">Jawa Tengah - Indonesia</td>
        </tr>
    </table>
    <hr>
 
</header>


<footer>
    <table style="width: 100%">
        <tr>
            <td>Dicetak oleh {{ request()->session()->get('username') }} ({{ date('d F Y - H:i:s') }})</td>
        </tr>
    </table>
</footer>

<main>
@php($_thp=0)
@php($_namaKaryawan=0)
        @foreach($karyawan as $x => $node)
        <table>
        <tr>
            <td class="text-bold" >Periode </td>
            <td>:</td>
            <td class="text-bold" >{{$node->periode}} </td>
        </tr>

        <tr>
            <td class="text-bold">NIP Karyawan</td>
            <td>:</td>
            <td >{{$node->nik}} </td>

            <th style="width: 20%"></th>
            <td class="text-bold">Departemen</td>
            <td>:</td>
            <td  >{{$node->departemen}} </td>

            <th style="width: 20%"></th>
            <td class="text-bold">Jabatan</td>
            <td>:</td>
            <td  >{{$node->jabatan}} </td>
        </tr>
        
        <tr>
            <td class="text-bold">Nama Karyawan </td>
            <td>:</td>
            <td  >{{$node->nama}} </td>
            <th style="width: 20%"></th>
            <td class="text-bold">Sub Departemen</td>
            <td>:</td>
            <td >{{$node->subDepartemen}} </td>

            <th style="width: 20%"></th>
            <td class="text-bold">No Rekening</td>
            <td>:</td>
            <td  >{{$node->noRekening}} </td>
        </tr>
        </table>
        @php($_thp+=$node->thp)
        @php($_namaKaryawan=$node->nama)
        @endforeach


    <table class="table-transaksi" style="width: 100%; padding-top: 0.2cm">
        <thead style="background-color: darkred; color: white">
        <tr class="text-center">
            <th class="text-center" style="width: 8%">No</th>
            <th class="text-left" style="width: 62%">Deskripsi</th>
            <th class="text-right" style="width: 30%">Jumlah</th>
       
        </tr>
        </thead>
        <tbody>
        @php($i=1)
        @php($_subTotal=0)
        @php($_firstLoad=0)
        @php($_total=0)
        @foreach($groupKonponenGaji as $x =>$node)
    
                @php($_subTotal=0)
                @foreach($komponenGaji as $v => $nodeKomGaji)
                   
                        @if($node->idSubGroup==$nodeKomGaji->idSubGroup)

                        @foreach($karyawan_gaji as $w => $nodeKarGaj)
                        @if($nodeKomGaji->id_variable==$nodeKarGaj->id_variable)
                        @if($nodeKarGaj->nominal!=0)
                        <tr>
                        <td class="text-center">></td> 
                        <td class="text-left">{{$nodeKomGaji->variable}}</td>
                        <td class="text-right">{{ number_format($nodeKarGaj->nominal)}}</td>
                        </tr>
                        @endif
                        @php($_total+=$nodeKarGaj->nominal)
                        @php($_subTotal+=$nodeKarGaj->nominal)
                        @php($i++) 
                        @endif
                        @endforeach
                    
                   
                        @endif       
                @endforeach

                <tr>
                <td></td>
                <td class="text-bold text-right">--- {{$node->sub_group}} ---</td>
                <td colspan="2" class="text-bold text-right">Rp. {{ number_format($_subTotal)}} </td>
                </tr>
   
        @endforeach
  



        <tr>
                <td class="text-center"></td>
                <td class="text-left"></td>
                <td class="text text-right">________________________ +</td>
        </tr>

       
        <tr>
                <td class="text-center">*</td>
                <td class="text-bold text-left" >TOTAL YANG DI TERIMA KARYAWAN</td>
                <td colspan="2" class="text-bold text-right">Rp. {{ number_format($_thp)}} </td>             
        </tr>

      

        </tbody>

    </table>

<div>
<br/>
        <br/>
        <br/>
        <br/>
<table>
<tr>
    <th>
    <div>
	<div style="width:400px;float:center">
		Penerima
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>{{$_namaKaryawan}}</p>
	</div>
	<div style="clear:both"></div>
</div>
    </th>

    <th>
    <div>
	<div style="width:500px;float:center">
		PT. PANORAMA INDAH PERMAI
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>HRD</p>
	</div>
	<div style="clear:both"></div>
</div>
    </th>
</tr>
</table>

    <div>
</main>

</body>
</html>