
<table>
        <thead>
        <tr class="text-center">
            <th >No</th>
            <th >Status Karyawan</th>
            <th >Departemen</th>
            <th >Sub Departemen</th>
            <th >Pos</th>
            <th >Grade</th>
            <th >Id Absen</th>
            <th >Nip</th>
            <th >Nama</th>
            <th >Tipe Kontrak</th>
            <th >Tanggal Bergabung</th>
            <th >Masa Kerja</th>
            <th >No Rekening</th>
            <th >Skema BPJS</th>
            <th >Skema Gaji</th>
            @php($i=1)
            @foreach($komponenGaji as $x)      
            <th >{{ $x->variable }}</th>
            @php($i++) 
            @endforeach
        </tr>
        </thead>
      
        <tbody>

        @php($i=1)
        @php($ii=1)
        @foreach($karyawan as $d)
  
            <tr>
                <td>{{ $i }}</td>

                @if($d->statusKaryawan==1)
                <td>Aktif</td>
                @elseif($d->statusKaryawan==2)
                <td>Non Aktif</td>
                @endif

                <td>{{ $d->departemen }}</td>
                <td>{{ $d->subDepartemen }}</td>
                <td>{{ $d->pos }}</td>
                <td>{{ $d->grade }}</td>
                <td>{{ $d->idAbsen }}</td>
                <td>{{ $d->nip }}</td>
                <td>{{ $d->nama }}</td>
                <td>{{ $d->tipeKontrak }}</td>
                <td>{{ $d->doj }}</td>
                <td>{{ $d->masaKerja }}</td>
                <td>{{ $d->noRekening }}</td>
                @if($d->tipeBpjs==0)
                <td>Perusahaan</td>
                @elseif($d->tipeBpjs==1)
                <td>Perusahaan</td>
                @elseif($d->tipeBpjs==2)
                <td>Tidak Ikut</td>
                @endif

                @if($d->skemaGaji==1)
                <td>Normal</td>
                @elseif($d->skemaGaji==2)
                <td>Harian</td>
                @elseif($d->skemaGaji==3)
                <td>Setengah(50%)</td>
                @endif

                @php($ii=1)
                @foreach($karyawan_gaji as $c)
                  
                    @if($d->idAbsen==$c->id_karyawan)
                        <td>{{ $c->nominal }}</td>
                        @php($ii++) 
                    @endif
               
                @endforeach
      
            </tr>
     
        @php($i++) 
             
        @endforeach

        </tbody>

       
    </table>