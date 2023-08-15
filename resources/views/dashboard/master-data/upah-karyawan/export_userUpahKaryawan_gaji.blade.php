
    <table>
        <thead>
        <tr class="text-center">
            <th >No</th>
            <th >TIPE</th>
            <th >ID DEPARTEMEN</th>
            <th >ID DEPARTEMEN SUB</th>
            <th >POS</th>
            <th >GRADE</th>
            <th >ID_ABSEN</th>
            <th >USERNAME</th>
            <th >NAMA</th>
            @php($i=1)
            @foreach($komponenGaji as $x)   
            @if($i < 8)     
            <th >{{ $x->variable }}</th>
            @else()
            @break 
            @endif
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
                <td>2</td>
                <td>{{ $d->departemen }}</td>
                <td>{{ $d->sub_departemen }}</td>
                <td>{{ $d->pos }}</td>
                <td>{{ $d->grade }}</td>
                <td>{{ $d->id_absen }}</td>
                <td>{{ $d->username }}</td>
                <td>{{ $d->nama }}</td>
                @php($ii=1)
                @foreach($karyawan_gaji as $c)
                  
                    @if($d->id_absen==$c->id_karyawan)
                        @if($ii < 8)
                        <td bgcolor="#d9ead3" >{{ $c->nominal }}</td>
                        @else()
                        @endif
                        @php($ii++) 
                    @endif
               
                @endforeach
            </tr>
     
        @php($i++) 
             
        @endforeach

        </tbody>

       
    </table>