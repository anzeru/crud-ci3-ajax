<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <script type="text/javascript" src="<?= base_url('assets/js/jquery-3.6.0.min.js') ?>"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>

    <div class="container">
        <h1>DATA BARANG</h1>

        <a href="#form" data-toggle="modal" class="btn btn-primary" onclick="submit('tambah')">Tambah Barang</a>

        <table class="table">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>KODE BARANG</th>
                    <th>NAMA BARANG</th>
                    <th>HARGA</th>
                    <th>STOK</th>
                    <th>AKSI</th>

                </tr>
            </thead>
            <tbody id="target">
                <!-- diisi dengan ajax -->
            </tbody>
        </table>

        <!-- Modal -->
        <div class="modal fade" id="form" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Data Barang</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="kode_barang" class="col-sm col-form-label">Kode Barang</label>
                                <div class="col-sm kosong">
                                    <input type="text" class="form-control" id="kode_barang" name="kode_barang" placeholder="Masukan Kode Barang" oninput="validData('kb')">

                                </div>
                                <input type="hidden" class="form-control" id="id" name="id" value="">
                            </div>
                            <div class="form-group">
                                <label for="nama_barang" class="col-sm col-form-label">Nama Barang</label>
                                <div class="col-sm kosong">
                                    <input type="text" class="form-control" id="nama_barang" name="nama_barang" placeholder="Masukan Nama Barang" oninput="validData('nb')">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="harga" class="col-sm col-form-label">Harga</label>
                                <div class="col-sm kosong">
                                    <input type="text" class="form-control" id="harga" name="harga" placeholder="Masukan Harga" oninput="validData('hrg')">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="stok" class="col-sm col-form-label">Stok</label>
                                <div class="col-sm kosong">
                                    <input type="text" class="form-control" id="stok" name="stok" placeholder="Masukan Stok" oninput="validData('stok')">
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="button" class="btn btn-primary" id="btn-tambah" onclick="tambahData()">Tambah</button>
                                <button type="button" class="btn btn-primary" id="btn-ubah" onclick="ubahData('')">Ubah</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>


    <script src="<?= base_url('assets/js/') ?>sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
</body>

</html>

<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,

    })

    ambilData()

    function ambilData() {
        $.ajax({
            type: 'POST',
            url: '<?= base_url('barang/ambildata') ?>',
            dataType: 'JSON',
            success: function(data) {
                var body = '';
                var no = 1;
                for (var i = 0; i < data.length; i++) {
                    body +=
                        '<tr>' +
                        '<td>' + no + ' </td>' +
                        '<td>' + data[i].kode_barang + ' </td>' +
                        '<td>' + data[i].nama_barang + '</td>' +
                        '<td>' + data[i].harga + '</td>' +
                        '<td>' + data[i].stok + '</td>' +
                        '<td><a href="#form" data-toggle="modal" class="badge badge-info" onclick="submit(' + data[i].id + ')">Ubah</a> <a href="#" onclick="hapusData(' + data[i].id + ')" class="badge badge-danger">Hapus</a></td>' +
                        '</tr>';
                    no++;
                }
                $('#target').html(body) // #target = id dari tbody | html(body) isi dari table tersebut
            }
        });
        $("input").change(function() {
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
            $(this).removeClass('is-invalid');
        });
    }

    function tambahData() {
        // menyimpan data-data yang dinputkan pada form ke dalam variable

        var kode_barang = $("[name='kode_barang']").val();
        var nama_barang = $("[name='nama_barang']").val();
        var harga = $("[name='harga']").val();
        var stok = $("[name='stok']").val();

        // selanjutnya pakai ajax untuk mengirim data-data diatas ke controlloer
        $.ajax({
            type: 'POST',
            data: 'kode_barang=' + kode_barang + '&nama_barang=' + nama_barang + '&harga=' + harga + '&stok=' + stok,
            url: '<?= base_url('barang/tambahdata') ?>',
            dataType: 'JSON',
            success: function(hasil) { // hasil didapatkan dari controller barang/tambahdata json encode pada line 53

                if (hasil.status) {

                    $('#form').modal('hide');
                    ambilData();
                    Toast.fire({
                        icon: 'success',
                        title: 'Data berhasil ditambah'
                    });
                } else {
                    for (var i = 0; i < hasil.inputerror.length; i++) {
                        $('[name="' + hasil.inputerror[i] + '"]').addClass('is-invalid'); // cari name = sesuai dari data yg dikirim dari barang/_validasi dan tambahkan class is-invalid
                        $('[name="' + hasil.inputerror[i] + '"]').closest('.kosong').append('<span></span>');
                        $('[name="' + hasil.inputerror[i] + '"]').next().text(hasil.error_string[i]).addClass('invalid-feedback');
                    }
                }
            }

        });

    }

    function submit(x) {
        if (x == 'tambah') {
            $('#btn-tambah').show()
            $('#btn-ubah').hide()

            // reset value pada input
            $('[name="id"]').val('');
            $('[name="kode_barang"]').val('');
            $('[name="nama_barang"]').val('');
            $('[name="harga"]').val('');
            $('[name="stok"]').val('');

            // reset class valid
            $('[name="kode_barang"]').removeClass('is-valid');
            $('[name="nama_barang"]').removeClass('is-valid');
            $('[name="harga"]').removeClass('is-valid');
            $('[name="stok"]').removeClass('is-valid');

            // reset kode_barang yg terdisabled saat klik ubah
            $('[name="kode_barang"]').prop('disabled', false)

        } else {
            $('#btn-tambah').hide()
            $('#btn-ubah').show()
            $('[name="kode_barang"]').prop('disabled', true)
            // $('[name="kode_barang"]').attr('disabled', 'disabled')
            // mengambil value data, utk ditampilkan saat klik Ubah
            // menggunakan ajax berdasarkan id yang dikirimkan
            $.ajax({
                type: 'POST',
                data: 'id=' + x,
                url: '<?= base_url('barang/ambilId') ?>',
                dataType: 'json',
                success: function(hasil) { // hasil didapatkan dari controller barang/ambilID json encode
                    // jika sukses lanjut menjalankan controller barang/ambilID
                    // console.log(hasil)
                    $('[name="id"]').val(hasil['id']);
                    $('[name="kode_barang"]').val(hasil['kode_barang']);
                    $('[name="nama_barang"]').val(hasil['nama_barang']);
                    $('[name="harga"]').val(hasil['harga']);
                    $('[name="stok"]').val(hasil['stok']);
                    // selanjutnya lakukan fungsi ubah data
                }
            });

        }
    }

    function ubahData() {
        var id = $("[name='id']").val();
        var kode_barang = $("[name='kode_barang']").val();
        var nama_barang = $("[name='nama_barang']").val();
        var harga = $("[name='harga']").val();
        var stok = $("[name='stok']").val();

        //mengirim data menggunakan ajax
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&kode_barang=' + kode_barang + '&nama_barang=' + nama_barang + '&harga=' + harga + '&stok=' + stok,
            url: '<?= base_url('barang/ubahdata') ?>',
            dataType: 'json',
            success: function(hasil) {

                $('#pesan').html(hasil.pesan);

                if (hasil.pesan == '') {
                    $('#form').modal('hide');
                    ambilData();
                    Toast.fire({
                        icon: 'success',
                        title: 'Data berhasil diubah'
                    })
                }
            }
        });
    }

    function hapusData(id) {
        // var tanya = confirm('Apakah anda yakin ingin mengapus data?');
        Swal.fire({
            title: 'Apa kamu yakin menghapus data?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Hapus'
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    type: 'post',
                    data: 'id=' + id,
                    url: '<?= base_url('barang/hapusdata') ?>',
                    success: function() {
                        ambilData();
                        Toast.fire({
                            icon: 'success',
                            title: 'Data berhasil dihapus'
                        })
                    }
                })
            }
        })
    }

    function validData(data) {
        if (data == 'kb') {
            var x = document.getElementById('kode_barang').value;
            if (x != '') {
                $('[name="kode_barang"]').addClass('is-valid');
            } else {
                $('[name="kode_barang"]').removeClass('is-valid');
            }
        }
        if (data == 'nb') {
            var y = document.getElementById('nama_barang').value;
            if (y != '') {
                $('[name="nama_barang"]').addClass('is-valid');
            } else {
                $('[name="nama_barang"]').removeClass('is-valid');
            }
        }
        if (data == 'hrg') {
            var z = document.getElementById('harga').value;
            if (z != '') {
                $('[name="harga"]').addClass('is-valid');
            } else {
                $('[name="harga"]').removeClass('is-valid');
            }
        }
        if (data == 'stok') {
            var zz = document.getElementById('stok').value;
            if (zz != '') {
                $('[name="stok"]').addClass('is-valid');
            } else {
                $('[name="stok"]').removeClass('is-valid');
            }
        }
    }
</script>