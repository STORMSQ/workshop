
<table>
<tr>
@foreach($title as $row)
<td>{{$row}}</td>
@endforeach
</tr>
@foreach($cell as $row)
<tr>
    @foreach($row as $data)
        <td>{{$data}}</td>
    @endforeach
</tr>
@endforeach

</table>