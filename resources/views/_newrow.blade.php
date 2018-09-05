<tr>
	<td> {{ $crud->id }} </td>
	<td> {{ $crud->nama }} </td>
	<td> {{ $crud->judul }} </td>
	<td>
		<button data-toggle="modal" data-target="#edit-item" class="btn btn-warning edit-item"> Edit </button>
		<button class="btn btn-danger remove-item"> Hapus </button>
	</td>
</tr>