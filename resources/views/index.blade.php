<!DOCTYPE html>
<html>
<head>
	<title> Crud ajax </title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
</head>
<body>
	<br>
	<div class="container" id="create-item">
		<h2>Input Data:</h2>
		<br>

		<form data-toggle="validator" id="form-submit" action="{{ route('cruds.store') }}" method="POST" name="form-submit">
			{{ csrf_field() }}
  			<div class="form-group">
				<label class="control-label" for="title">Nama:</label>
				<input type="text" name="nama" class="form-control" data-error="Masukan Nama"  />
				<div class="help-block with-errors"></div>
			</div>

			<div class="form-group">
				<label class="control-label" for="title">Judul:</label>
				<textarea name="judul" class="form-control" data-error="Masukan Judul." ></textarea>
				<div class="help-block with-errors"></div>
			</div>

			<div class="form-group">
				<button type="submit" id="submit" class="btn crud-submit btn-success" value="add">Submit</button>
			</div>
      	</form>
     </div>

        <div class="modal fade" id="edit-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit Data</h4>
              </div>
              <div class="modal-body">
                    <form data-toggle="validator" action="/cruds/" method="PUT">
                        <div class="form-group">
                            <label class="control-label" for="title">Nama</label>
                            <input type="text" name="nama" class="form-control" data-error="Please enter title." required />
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="title">Judul :</label>
                            <textarea name="judul" class="form-control" data-error="Please enter description." required></textarea>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success crud-submit-edit">Submit</button>
                        </div>
                    </form>
              </div>
            </div>
          </div>
        </div>

<br>
<br>
	<div class="container">
		<table class="table table-striped table-bordered">
			<h2>List Barang</h2>
			
			<thead>
				<tr>
					<th style="width: 30px">ID</th>
					<th>Nama</th>
					<th>Judul</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach ( $cruds as $value )
				<tr>
					<td> {{ $value->id }} </td>
					<td> {{ $value->nama }} </td>
					<td> {{ $value->judul }} </td>
					<td>
						<button data-toggle="modal" data-target="#edit-item" class="btn btn-warning edit-item"> Edit </button>
						<button class="btn btn-danger remove-item"> Hapus </button>
					</td>
				</tr>
			@endforeach
			</tbody>		
		</table>

	</div>
</body>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script type="text/javascript">
		var url = {{ route('cruds.index') }}
	</script>
	<script type="text/javascript">


$.ajaxSetup({
    headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
});


// /* Get Page Data*/
// function getPageData() {
// 	$.ajax({
//     	dataType: 'json',
//     	url: url,
//     	data: {page:page}
// 	}).done(function(data){
// 		manageRow(data.data);
// 	});
// }


/* Add new Item table row */
 function manageRow(data) {
 	var	rows = '';
 	$.each( data, function( key, value ) {
 	  	rows = rows + '<tr>';
 	  	rows = rows + '<td>'+value.id+'</td>';
        rows = rows + '<td>'+value.nama+'</td>';
        rows = rows + '<td>'+value.judul+'</td>';
        rows = rows + '<button data-toggle="modal" data-target="#edit-item" class="btn btn-primary edit-item">Edit</button> ';
        rows = rows + '<button class="btn btn-danger remove-item"> Delete </button>';
        rows = rows + '</td></center>';
 	  	rows = rows + '</tr>';
 	});


	$("tbody").html(rows);
 }



/* Create new Item */
$(".crud-submit").click(function(e){
    e.preventDefault();
    var form_action = $("#create-item").find("form").attr("action");
    var form = $('#form-submit').serialize();
  //  var nama = $("#create-item").find("input[name='nama']").val();
  //  var judul = $("#create-item").find("input[name='judul']").val();


    $.ajax({
        dataType: 'json',
        type:'POST',
        url: form_action,
        data: form,
    }).done(function(data){
        // getPageData();
        // $(".modal").modal('hide');
        // toastr.success('Item Created Successfully.', 'Success Alert', {timeOut: 1000});
		$('tbody').append(data.html);
		console.log(data);
    });


});


/* Remove Item */
 $("body").on("click",".remove-item",function(){
    var id = $(this).parent("td").data('id');
    var c_obj = $(this).parents("tr");
    $.ajax({
        dataType: 'json',
        type:'delete',
        url: url + '/' + id,
    }).done(function(data){
            c_obj.remove();
            toastr.success('Item Deleted Successfully.', 'Success Alert', {timeOut: 1000});
            getPageData();
    });
});
     




/* Edit Item */
$("body").on("click",".edit-item",function(){
    var id = $(this).parent("td").data('id');
    var nama = $(this).parent("td").prev("td").prev("td").prev("td").text();
    var judul = $(this).parent("td").prev("td").prev("td").text();

 
    $("#edit-item").find("input[name='nama']").val(nama);
    $("#edit-item").find("input[name='judul']").val(judul);
    //$("#edit-item").find("form").attr("action",url + '/' + id);
});


/* Updated new Item */
$(".crud-submit-edit").click(function(e){
    e.preventDefault();
    var form_action = $("#edit-item").find("form").attr("action");
    var nama = $("#edit-item").find("input[name='nama']").val();
    var judul = $("#edit-item").find("input[name='alamat']").val();


    $.ajax({
        dataType: 'json',
        type:'PUT',
        url: form_action,
        data:{nama:nama, judul:judul}
    }).done(function(data){
        getPageData();
        $(".modal").modal('hide');
        toastr.success('Item Updated Successfully.', 'Success Alert', {timeOut: 1000});
    });
});


	</script>
</html>