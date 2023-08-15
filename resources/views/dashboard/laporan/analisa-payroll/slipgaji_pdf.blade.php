<!DOCTYPE html>
<html lang="id">
<head>
    <title>Payroll Saloka Park </title>
    <link rel="stylesheet" href="{{ public_path('assets/pdf/portrait.css') }}">
</head>

<body style="border: 1px solid #000; margin: 0px; padding: 8px 8px;">
<header>
    <table style="width: 100%">
        <tr>
            <td rowspan="5" style="width: 20%">           
                 <!-- <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logoPIP.png'))) }}" class="logo" alt="Logo">  -->
            </td>
          
            <td class="header-tj-slip" style="width: 60%">SLIP GAJI</td>
            <td rowspan="5"></td>
        </tr>
        <tr>
            <td class="text-bold">PT. PANORAMA INDAH PERMAI</td>
        </tr>
      
        <tr>
            <td class="text-bold">Jl. Fatmawati no. 154, Lopait, Tuntang</td>
        </tr>
   
    </table>
    <hr>
</header>


<footer>
    <table style="width: 100%">
        <tr>
            <td>Dicetak oleh {{ request()->session()->get('name') }} ({{ date('d F Y - H:i:s') }})</td>
        </tr>
    </table>
</footer>

<main>
@php($_thp=0)
@php($_namaKaryawan=0)
        @foreach($karyawan as $x => $node)
        <table style="padding-top: 1cm">
    
        <tr>
            <td class="text-bold" >Periode </td>
            <td>:</td>
            <td class="text-bold" >{{$node->periode}} </td>
        </tr>

        <tr>
            <td class="text-bold">NIP</td>
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
            <td class="text-bold">Nama </td>
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
     

        <table style="width: 100%; padding-top: 0.5cm">
        <tr>
            <td class="header-tj" style="width: 100%">Absensi</td>
            </tr>
        </table>

        <table style="width: 100%; padding-top: 0.2cm;padding: 0.5cm">
            <tr>
                <td class="text-bold">Total Masuk </td>
                <td>:</td>
                <td>{{ $kehadiran_karyawan->totMasuk }} Hari</td> 
                <td class="text-bold">Total Izin </td>
                <td>:</td>
                <td>{{ $kehadiran_karyawan->totIzin }} Hari</td>
                <td class="text-bold">Total Sakit </td>
                <td>:</td>
                <td>{{ $kehadiran_karyawan->totSakit }} Hari</td>
            </tr>
            <tr>
                <td class="text-bold">Total Libur </td>
                <td>:</td>
                <td>{{ $kehadiran_karyawan->totLibur }} Hari</td>
                <td class="text-bold">Total PH </td>
                <td>:</td>
                <td>{{ $kehadiran_karyawan->totPh }} Hari</td>
                <td class="text-bold">Total Alfa </td>
                <td>:</td>
                <td>{{ $kehadiran_karyawan->totAlfa }} Hari</td>
                <td class="text-bold">Total Cuti </td>
                <td>:</td>
                <td>{{ $kehadiran_karyawan->totCuti }} Hari</td>
            </tr>
        </table>

          <table style="width: 100%; padding-top: 0.5cm">
        <tr>
            <td class="header-tj" style="width: 100%">Upah Tetap</td>
            </tr>
        </table>
     
        @php($_total=0)
        @php($_subTotal=0)
        @php($_bruto=0)
        <table style="width: 100%; padding-top: 0.2cm">
        <tbody>
                @php($i=1)
                @php($_subTotal=0)
                @foreach($komponenGaji_upahTetap as $v => $nodeKomGaji)
                        @foreach($karyawan_gaji as $w => $nodeKarGaj)
                        @if($nodeKomGaji->id_variable==$nodeKarGaj->id_variable)
                        <tr>
                        <td class="text-center">></td> 
                        <td class="text-left">{{$nodeKomGaji->variable}}</td>
                        <td class="text-right">{{ number_format($nodeKarGaj->nominal)}}</td>
                        </tr>
                      
                        @php($_total+=$nodeKarGaj->nominal)
                        @php($_subTotal+=$nodeKarGaj->nominal)
                        @php($_bruto+=$nodeKarGaj->nominal)
                        @php($i++) 
                        @endif
                        @endforeach 
                @endforeach
                        @if($node->skemaGaji=='2')
                       
                        @endif
        <tr>
                <td class="text-center"></td>
                <td class="text-left"></td>
                <td class="text text-right">________________________ +</td>
        </tr>
        <tr>
                <td class="text-center"> </td>
                <td class="text-center"> </td>
                @if($node->skemaGaji=='2')
                <td colspan="2" class="text-bold text-right">(Prorate) Rp. {{ number_format($_subTotal)}} </td>     
                @elseif($node->skemaGaji=='3')
                <td colspan="2" class="text-bold text-right">(50%) Rp. {{ number_format($_subTotal)}} </td> 
                @else
                <td colspan="2" class="text-bold text-right">Rp. {{ number_format($_subTotal)}} </td>         
                @endif
              
        </tr>
        </tbody>
    </table>

        <table style="width: 100%">
        <tr>
            <td class="header-tj" style="width: 100%">Upah Variable</td>
            </tr>
        </table>

        <table style="width: 100%; padding-top: 0.2cm">
        <tbody>
                @php($i=1)
                @php($_subTotal=0)
                @foreach($komponenGaji_upahVariable as $v => $nodeKomGaji)
                        @foreach($karyawan_gaji as $w => $nodeKarGaj)
                        @if($nodeKomGaji->id_variable==$nodeKarGaj->id_variable)
                        <tr>
                        <td class="text-center">></td> 
                        <td class="text-left">{{$nodeKomGaji->variable}}</td>
                        <td class="text-right">{{ number_format($nodeKarGaj->nominal)}}</td>
                        </tr>
                            @if(($nodeKomGaji->id_variable=='VR-007') && ($nodeKarGaj->nominal <> 0))
                            <tr>
                            <td class="text-center"> </td> 
                            <td class="text-left" style="font-style: italic">( {{$nodeKarGaj->keterangan}} )</td>
                            <td class="text-right"> </td>
                            </tr>
                            @endif
                        @php($_total+=$nodeKarGaj->nominal)
                        @php($_subTotal+=$nodeKarGaj->nominal)
                        @php($_bruto+=$nodeKarGaj->nominal)
                        @php($i++) 
                        @endif
                        @endforeach 
                @endforeach
        <tr>
                <td class="text-center"></td>
                <td class="text-left"></td>
                <td class="text text-right">________________________ +</td>
        </tr>
        <tr>
                <td class="text-center"> </td>
                <td class="text-bold text-right" ></td>
                <td colspan="2" class="text-bold text-right">BRUTO : Rp. {{ number_format($_bruto)}} </td>             
        </tr>
        </tbody>
    </table>
    

        <table style="width: 100%">
        <tr>
            <td class="header-tj" style="width: 100%">Potongan</td>
            </tr>
        </table>

        @php($_total=0)
        @php($_subTotal=0)
        <table style="width: 100%; padding-top: 0.2cm">
        <tbody>
                @php($i=1)
                @php($_subTotal=0)
                @foreach($komponenGaji_potongan as $v => $nodeKomGaji)
                        @foreach($karyawan_gaji as $w => $nodeKarGaj)
                        @if($nodeKomGaji->id_variable==$nodeKarGaj->id_variable)
                        <tr>
                        <td class="text-center">></td> 
                        <td class="text-left">{{$nodeKomGaji->variable}}</td>
                        <td class="text-right">{{ number_format($nodeKarGaj->nominal)}}</td>
                        </tr>
                            @if(($nodeKomGaji->id_variable=='VR-012') && ($nodeKarGaj->nominal <> 0))
                            <tr>
                            <td class="text-center"> </td> 
                            <td class="text-left" style="font-style: italic">( {{$nodeKarGaj->keterangan}} )</td>
                            <td class="text-right"> </td>
                            </tr>
                            @endif
                        @php($_total+=$nodeKarGaj->nominal)
                        @php($_subTotal+=$nodeKarGaj->nominal)
                        @php($i++) 
                        @endif
                        @endforeach 
                @endforeach
        <tr>
                <td class="text-center"></td>
                <td class="text-left"></td>
                <td class="text text-right">________________________ +</td>
        </tr>
        <tr>
                <td class="text-center"> </td>
                <td class="text-bold text-left" > </td>
                <td colspan="2" class="text-bold text-right">Rp. {{ number_format($_subTotal)}} </td>             
        </tr>

  
        
        </tbody>
        </table>
        
        <table style="width: 100%; padding-top: 0.2cm">
        <tr>
                <td class="text-center"> </td>
                <td class="text-bold text-right header-tj" >TOTAL YANG DI TERIMA KARYAWAN</td>
                <td colspan="2" class="text-bold text-right header-tj">Rp. {{ number_format($_thp)}} </td>             
        </tr>
        </table>
     

        <table style="width: 100%; padding-top: 0.2cm">
        <tbody>
               <tr>
                    <td>* Catatan (Lain-lain)</td>                 
                </tr> 
                @foreach($komponenGaji_bpjsPerusahaan as $v => $nodeKomGaji)
                        @foreach($karyawan_gaji as $w => $nodeKarGaj)
                        @if($nodeKomGaji->id_variable==$nodeKarGaj->id_variable)
                        <tr>
                        <td>{{$nodeKomGaji->variable}} yang dibayarkan Rp.{{ number_format($nodeKarGaj->nominal)}}</td>
                        
                        </tr>
                        @endif
                        @endforeach 
                @endforeach
        </tbody>
        </table>

    <div>
    <div>
    @endforeach
</main>

</body>
</html>