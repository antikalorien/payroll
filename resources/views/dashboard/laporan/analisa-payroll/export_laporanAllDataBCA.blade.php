
    <table>
        <thead>
        <tr class="text-center">
            <th >No.Rekening</th>
            <th >Jumlah Transfer</th>
            <th >NIP</th>
            <th >Nama Karyawan</th>
        </tr>
        </thead>
      
        <tbody>

        @php($i=1)
        @php($ii=1)
        @foreach($karyawan as $d)
            <tr>
                <td>{{ $d->noRekening }}</td>
                <td>{{ $d->thp }}</td>
                <td>{{ $d->nip }}</td>
                <td>{{ $d->nama }}</td>
            </tr>
     
        @php($i++) 
             
        @endforeach

        </tbody>

       
    </table>