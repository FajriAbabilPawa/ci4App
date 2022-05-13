<?= $this->extend("layouts/app") ?>

<?= $this->section("body") ?>

<?php

use App\Models\ModelMahasiswa;
use App\Controllers\Mahasiswa;
use CodeIgniter\Filters\CSRF;

$session = \Config\Services::session();

//? Tempat testing dan debug
// dd($this->db->insert_id());
// dd(old('jurusan_edit'));
?>


<div class="container my-3">
    <div class="row">
        <div class="col-6">
            <h1>Halo, <?= $session->get('username') ?></h1>
            <form action="" method="get">
                <div class="input-group mb-3">
                    <input name="keyword" type="search" class="form-control" placeholder="Masukan kata kunci..." value="<?php echo session()->get('keyword') ?>">
                    <button class="btn btn-outline-primary" type="submit" name="submit">Cari</button>
                    <?php if (session()->getFlashdata('home')) : ?>
                        <a class="btn btn-success" href="<?php echo base_url("mahasiswa") ?>">Home</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="container my-2">
    <?php $validation->listErrors() ?>
    <div class="d-flex justify-content-between my-3">
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</button>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNewDataModal">Tambah Data</button>
    </div>
    <div class="success">
        <?php if ($session->getFlashdata('success_add')) : ?>
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                    <use xlink:href="#check-circle-fill" />
                </svg>
                <div class="text ms-3">
                    <strong><?= $session->getFlashdata('success_add'); ?></strong>
                    <a class="mb-0 alert-link" data-bs-toggle="modal" data-bs-target="<?php echo ($session->getFlashdata('success_add')) ? '#editDataModal' . session()->getFlashdata('id') : '';  ?>" style="cursor: pointer;"><?= session()->get('nama') . ' ' . '(' . $session->getFlashdata('nim') . ')'; ?></a>
                </div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if ($session->getFlashdata('success_edit')) : ?>
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                    <use xlink:href="#check-circle-fill" />
                </svg>
                <div class="text ms-3">
                    <strong><?= $session->getFlashdata('success_edit'); ?></strong>
                    <br>
                    <a class="mb-0 alert-link" data-bs-toggle="modal" data-bs-target="<?php echo ($session->getFlashdata('success_edit') ? '#editDataModal' . $session->get('id') : '');  ?>" style="cursor: pointer; text-decoration: underline;"><?= session()->get('nama') . ' ' . '(' . session()->get('nim') . ')'; ?></a>
                </div>
                <button onclick="resetColor()" type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
    </div>

    <div class="fail">
        <?php if ($validation->getErrors()) : ?>
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                    <use xlink:href="#exclamation-triangle-fill" />
                </svg>
                <div class="ms-3">
                    <h4 class="alert-heading">Input tidak sesuai ketentuan</h4>
                    <span>Gagal <?php echo $session->getFlashdata('fail_add') ? 'menambahkan data' : ($session->getFlashdata('fail_edit') ? 'mengedit' . ' data ' . '<a class="alert-link" data-bs-toggle="modal" data-bs-target="#editDataModal' . $session->get('id') . '" style="cursor: pointer;text-decoration: none;">' .  session()->get('nama') . ' ' . '(' . old('nim_edit') . ')' . '</a>' : 'menambahkan/mengedit data'); ?></span>
                    <br>
                    <a class="mb-0 alert-link" data-bs-toggle="modal" data-bs-target="<?php echo $session->getFlashdata('fail_add') ? '#addNewDataModal' : ($session->getFlashdata('fail_edit') ? '#editDataModal' . $session->get('id') : ' ');  ?>" style="cursor: pointer; text-decoration: underline;">Coba Lagi</a>
                </div>
            </div>
        <?php endif;
        ?>
    </div>

    <div class="info">
        <?php if ($session->getFlashdata('deleted')) : ?>
            <div class="alert alert-warning d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                    <use xlink:href="#info-fill" />
                </svg>
                <div class="text ms-3">
                    <strong><?= $session->getFlashdata('deleted'); ?></strong>
                </div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <!-- <? //php if ($session->getFlashdata('fail_search')) : 
                ?>
            <div class="alert alert-warning d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                    <use xlink:href="#info-fill" />
                </svg>
                <div class="text ms-3">
                    <strong><? //= $session->getFlashdata('fail_search'); 
                            ?></strong>
                </div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <? //php endif; 
        ?> -->
    </div>
    <?php
    // cek kalo databases ada isinya
    // dd(session()->getFlashdata());
    if (session()->getFlashdata('fail_search') == true) { ?>
        echo session()->getFlashdata('fail_search');
    <?php } else if (empty($mahasiswa)) { ?>
        <div class="container">
            <div class="row">
                <h3 class="text-center">Data <?php echo $keyword = (session()->get('keyword')) ? '"' . session()->get('keyword') . '"' : 'Mahasiswa'; ?> Kosong</h3>
                <a class="text-center" data-bs-toggle="modal" data-bs-target="#addNewDataModal" style="cursor: pointer;text-decoration: none; color:aqubluea"><i class="bi bi-cloud-arrow-up-fill"></i> Silahkan tambah data <i class="bi bi-cloud-arrow-up-fill"></i></a>
            </div>
        </div>
    <?php } else { ?>
        <div class="mb-3" style="overflow-x:auto;">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Action</th>
                        <th scope="col">No</th>
                        <th scope="col">NIM</th>
                        <th scope="col">Nama Mahasiswa</th>
                        <th scope="col">Tempat<br>Tanggal Lahir</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">Nomor HP</th>
                        <th scope="col">Jurusan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $no = 1 + (5 * ($page - 1));
                    // $no = count($mahasiswa) * $page - (count($mahasiswa) - 1);

                    foreach ($mahasiswa as  $row) :
                    ?>

                        <tr>
                            <!-- Tombol Edit & Hapus -->
                            <th class="row my-auto">
                                <a class="col-6" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $row->id_mhs; ?>"><i class="bi bi-trash-fill" style="color: red; cursor: pointer;text-decoration: none;"></i></a>

                                <a id="editModalBtn" class="col-6" data-bs-toggle="modal" data-bs-target="#editDataModal<?php echo $row->id_mhs; ?>"><i class="bi bi-pencil-fill" style="cursor: pointer;text-decoration: none; color:<?php echo (session()->getFlashdata('fail_edit')) ? (($session->get('id') == $row->id_mhs) ? 'orange' : 'black') : ((session()->getFlashdata('success_edit')) ? (($session->get('id') == $row->id_mhs) ? 'green' : 'black') : 'black'); ?>;"></i></a>

                                <?php $session->markAsTempdata('id', 2); //Hapus session id biar tombolnya bisa balik jadi warning lagi 
                                ?>
                            </th>

                            <td><?= $no++; ?></td>
                            <td><?= $row->nim_mhs ?></td>
                            <td><?= $row->nama_mhs ?></td>
                            <td><?= $row->TmpLahir_mhs . '<br>' . $row->TglLahir_mhs ?></td>
                            <td><?= $row->alamat_mhs ?></td>
                            <td><?= $row->hp_mhs ?></td>
                            <td><?= $row->jurusan_mhs ?></td>
                        </tr>
                <?php endforeach;
                } ?>
                </tbody>
            </table>
        </div>
        <?= $pager->links('mahasiswa', 'mahasiswa_pagination') ?>
</div>


<!-- Modal Tambah Data -->
<div class=" modal fade addNewDataModal" id="addNewDataModal" tabindex="-1" aria-labelledby="AddNewDataModalLabel" aria-labelledby="formAddNewData" aria-hidden="true">
    <!-- Tambah Data Modal Dialog -->
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">Tambah data baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php echo form_open('mahasiswa/SimpanData');
                echo csrf_field(); ?>

                <form method="POST" id="formAddNewData" enctype="multipart/form-data">
                    <!-- <div class="form-floating mb-3">
                        <input type="number" name="nim" maxlength="7" placeholder="nim" id="inputNim" class="form-control <? //= ($validation->hasError('nim')) ? 'is-invalid' : 'is-valid'; 
                                                                                                                            ?>" value="<? //= old('nim'); 
                                                                                                                                        ?>" autofocus required>
                        <label for="inputNim">NIM</label>
                        <? //php if ($validation->getError('nim')) { 
                        ?>
                            <div class='invalid-feedback'>
                                <? //= $error = $validation->getError('nim'); 
                                ?>
                            </div>
                        <? //php } 
                        ?>
                    </div> -->
                    <div class="form-floating mb-3">
                        <input type="text" name="nama" size="255" placeholder="Nama" id="inputNama" class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" value="<?= old('nama'); ?>" required>
                        <label for="inputNama">Nama</label>
                        <?php if ($validation->getError('nama')) { ?>
                            <div class='invalid-feedback'>
                                <?= $error = $validation->getError('nama'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="TmpLahir" size="255" placeholder="TempatLahir" id="inputTempatLahir" class="form-control <?= ($validation->hasError('TmpLahir')) ? 'is-invalid' : ''; ?>" value="<?= old('TmpLahir'); ?>" required>
                        <label for="inputTempatLahir">Tempat Lahir</label>
                        <?php if ($validation->getError('TmpLahir')) { ?>
                            <div class='invalid-feedback'>
                                <?= $error = $validation->getError('TmpLahir'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="date" name="TglLahir" placeholder="TanggalLahir" id="inputTanggalLahir" class="form-control <?= ($validation->hasError('TglLahir')) ? 'is-invalid' : ''; ?>" value="<?= old('TglLahir'); ?>" required>
                        <label for="inputTanggalLahir">Tanggal Lahir</label>
                        <?php if ($validation->getError('TglLahir')) { ?>
                            <div class='invalid-feedback'>
                                <?= $error = $validation->getError('TglLahir'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="alamat" size="255" placeholder="Alamat" id="inputAlamat" class="form-control <?= ($validation->hasError('alamat')) ? 'is-invalid' : ''; ?>" value="<?= old('alamat'); ?>" required>
                        <label for="inputAlamat">Alamat</label>
                        <?php if ($validation->getError('alamat')) { ?>
                            <div class='invalid-feedback'>
                                <?= $error = $validation->getError('alamat'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="tel" name="telepon" maxlength="13" placeholder="Telepon" id="inputTelepon" pattern="{0-9}+" class="form-control <?= ($validation->hasError('telepon')) ? 'is-invalid' : ''; ?>" value="<?= old('telepon'); ?>" required>
                        <label for="inputTelepon">HP/Telepon</label>
                        <?php if ($validation->getError('telepon')) { ?>
                            <div class='invalid-feedback'>
                                <?= $error = $validation->getError('telepon'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="form-floating mb-0">
                        <select class="form-control <?= ($validation->hasError('jurusan')) ? 'is-invalid' : ''; ?>" name="jurusan" id="jurusan" required>
                            <option value="sejarah" <?= (old('jurusan') == 'sejarah') ? 'selected' : ''; ?>>Sejarah</option>
                            <option value="mipa" <?= (old('jurusan') == 'mipa') ? 'selected' : '' ?>>Matematika & IPA</option>
                            <option value="sastra" <?= (old('jurusan') == 'sastra') ? 'selected' : ''; ?>>Sastra</option>
                        </select>
                        <label for="inputJurusan">Jurusan</label>
                        <?php if ($validation->getError('jurusan')) { ?>
                            <div class='invalid-feedback'>
                                <?= $error = $validation->getError('jurusan'); ?>
                            </div>
                        <?php } ?>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" name="tutup" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" name="SimpanData" value="simpandata" id="SimpanData" class="btn btn-primary">Tambah</button>
                <div class=" response-message ms-3">
                </div>
            </div>
            </form><?= form_close(); ?>
        </div>
    </div>
</div>

<!-- Modal Edit data -->
<?php
$id_mhs = 0;

foreach ($mahasiswa as  $row) :
    $id_mhs++;
?>

    <div class="modal fade" id="editDataModal<?php echo $row->id_mhs; ?>" tabindex="-1" aria-labelledby="EditDataModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="formEditData" aria-hidden="true">
        <!-- Edit Data Modal Dialog -->
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Edit Data <?php echo $row->nama_mhs . ' ' .  '(' . $row->nim_mhs . ')' ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?= form_open('mahasiswa/UpdateData/');
                    echo csrf_field();
                    ?>

                    <form method="POST" action="echo base_url('mahasiswa/UpdateData')" enctype="multipart/form-data">
                        <div class="form-floating mb-0">
                            <input type="number" hidden name="id" placeholder="id" id="inputId" class="form-control" value="<?php echo $row->id_mhs ?>">

                            <input type="text" name="nim_edit" maxlength="7" placeholder="nim" id="inputNim" class="form-control" value="<?php echo $row->nim_mhs; ?>" hidden>
                            <label for="inputNim">NIM</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="nama_edit" size="255" placeholder="Nama" id="inputNama" class="form-control <?php if (old('id') == $row->id_mhs) : ?><?= ($validation->hasError('nama_edit')) ? 'is-invalid' : 'is-valid'; ?><?php endif; ?>" value="<?php echo old('id') == $row->id_mhs ? old('nama_edit') : $row->nama_mhs ?>" required>
                            <label for="inputNama">Nama</label>

                            <?php if (old('id') == $row->id_mhs) {
                                if ($validation->getError('nama_edit')) { ?>
                                    <div class='invalid-feedback'>
                                        <?= $error = $validation->getError('nama_edit'); ?>
                                    </div><?php
                                        }
                                    } ?>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="TmpLahir_edit" size="255" placeholder="TempatLahir" id="inputTempatLahir" class="form-control <?php if (old('id') == $row->id_mhs) : ?><?= ($validation->hasError('TmpLahir_edit')) ? 'is-invalid' : 'is-valid'; ?><?php endif; ?>" value="<?php echo old('id') == $row->id_mhs ? old('TmpLahir_edit') : $row->TmpLahir_mhs ?>" required>
                            <label for="inputTempatLahir">Tempat Lahir</label>

                            <?php if (old('id') == $row->id_mhs) {
                                if ($validation->getError('TmpLahir_edit')) { ?>
                                    <div class='invalid-feedback'>
                                        <?= $error = $validation->getError('TmpLahir_edit'); ?>
                                    </div><?php
                                        }
                                    } ?>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="date" name="TglLahir_edit" placeholder="TanggalLahir" id="inputTanggalLahir" class="form-control <?php if (old('id') == $row->id_mhs) : ?><?= ($validation->hasError('TglLahir_edit')) ? 'is-invalid' : 'is-valid'; ?><?php endif; ?>" value="<?php echo old('id') == $row->id_mhs ? old('TglLahir_edit') : $row->TglLahir_mhs ?>" required>
                            <label for="inputTanggalLahir">Tanggal Lahir</label>

                            <?php if (old('id') == $row->id_mhs) {
                                if ($validation->getError('TglLahir_edit')) { ?>
                                    <div class='invalid-feedback'>
                                        <?= $error = $validation->getError('TglLahir_edit'); ?>
                                    </div><?php
                                        }
                                    } ?>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="alamat_edit" size="255" placeholder="Alamat" id="inputAlamat" class="form-control <?php if (old('id') == $row->id_mhs) : ?><?= ($validation->hasError('alamat_edit')) ? 'is-invalid' : 'is-valid'; ?><?php endif; ?>" value="<?php echo old('id') == $row->id_mhs ? old('alamat_edit') : $row->alamat_mhs ?>" required>
                            <label for="inputAlamat">Alamat</label>

                            <?php if (old('id') == $row->id_mhs) {
                                if ($validation->getError('alamat_edit')) { ?>
                                    <div class='invalid-feedback'>
                                        <?= $error = $validation->getError('alamat_edit'); ?>
                                    </div><?php
                                        }
                                    } ?>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="tel" name="telepon_edit" maxlength="13" placeholder="Telepon" id="inputTelepon" pattern="{0-9}+" class="form-control <?php if (old('id') == $row->id_mhs) : ?><?= ($validation->hasError('telepon_edit')) ? 'is-invalid' : 'is-valid'; ?><?php endif; ?>" value="<?php echo old('id') == $row->id_mhs ? old('telepon_edit') : $row->hp_mhs ?>" required>
                            <label for="inputTelepon">HP/Telepon</label>

                            <?php if (old('id') == $row->id_mhs) {
                                if ($validation->getError('telepon_edit')) { ?>
                                    <div class='invalid-feedback'>
                                        <?= $error = $validation->getError('telepon_edit'); ?>
                                    </div><?php
                                        }
                                    } ?>
                        </div>
                        <div class="form-floating mb-0">
                            <select class="form-control <?php if (old('id') == $row->id_mhs) : ?><?= ($validation->hasError('jurusan_edit')) ? 'is-invalid' : ''; ?><?php endif; ?>" name="jurusan_edit" id="jurusan_edit" required>
                                <?php if ($validation->hasError('jurusan_edit')) { ?>
                                    <option value="sejarah" <?= (old('jurusan') == 'sejarah') ? 'selected' : ''; ?>>Sejarah</option>
                                    <option value="mipa" <?= (old('jurusan') == 'mipa') ? 'selected' : '' ?>>Matematika & IPA</option>
                                    <option value="sastra" <?= (old('jurusan') == 'sastra') ? 'selected' : ''; ?>>Sastra</option>
                                <?php } else { ?>
                                    <option value="sejarah" <?= ($row->jurusan_mhs == 'Sejarah') ? 'selected' : ''; ?>>Sejarah</option>
                                    <option value="mipa" <?= ($row->jurusan_mhs == 'MIPA') ? 'selected' : '' ?>>Matematika & IPA</option>
                                    <option value="sastra" <?= ($row->jurusan_mhs == 'Sastra') ? 'selected' : ''; ?>>Sastra</option>
                                <?php } ?>
                            </select>
                            <label for="inputJurusan">Jurusan</label>
                            <?php if (old('id') == $row->id_mhs) {
                                if ($validation->getError('jurusan_edit')) { ?>
                                    <div class='invalid-feedback'>
                                        <?= $error = $validation->getError('jurusan_edit'); ?>
                                    </div><?php
                                        }
                                    } ?>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" value="UpdateData" class="btn btn-primary">Update</button>
                </div>
                </form> <?= form_close(); ?>
            </div>
        </div>
    </div>


    <!-- Hapus Data -->
    <div class="modal fade deleteModal" id="deleteModal<?= $row->id_mhs; ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-labelledby="formAddNewData" aria-hidden="true">
        <!-- Data Hapus Dialog -->
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Data <?php echo $row->nama_mhs . ' ' . '(' . $row->nim_mhs . ')' ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php echo form_open('mahasiswa/hapus');
                    echo csrf_field(); ?>

                    <form method="post" id="deleteModal" enctype="multipart/form-data">
                        <div class="form-floating mb-0">
                            <input type="number" name="id" placeholder="id" class="form-control" value="<?= $row->id_mhs; ?>" hidden>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="nim" placeholder="nim" id="inputNim" class="form-control" value="<?= $row->nim_mhs; ?>" disabled>
                            <label for="inputNim">NIM</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="nama" placeholder="Nama" id="inputNama" class="form-control" value="<?= $row->nama_mhs; ?>" disabled>
                            <label for="inputNama">Nama</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="TmpLahir" size="255" placeholder="TempatLahir" id="inputTempatLahir" class="form-control" value="<?= $row->TmpLahir_mhs; ?>" disabled>
                            <label for="inputTempatLahir">Tempat Lahir</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="date" name="TglLahir" placeholder="TanggalLahir" id="inputTanggalLahir" class="form-control" value="<?= $row->TglLahir_mhs; ?>" disabled>
                            <label for="inputTanggalLahir">Tanggal Lahir</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea type="text" name="alamat" placeholder="Alamat" id="inputAlamat" class="form-control" disabled><?= $row->alamat_mhs; ?></textarea>
                            <label for="inputAlamat">Alamat</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="tel" name="telepon" placeholder="Telepon" id="inputTelepon" class="form-control" value="<?= $row->hp_mhs; ?>" disabled>
                            <label for="inputTelepon">No. HP</label>
                        </div>
                        <div class="form-floating mb-0">
                            <input type="text" name="jurusan" placeholder="Jurusan" id="inputJurusan" class="form-control" value="<?= $jurusan = ($row->jurusan_mhs == 'Sejarah') ? 'Sejarah' : (($row->jurusan_mhs == 'MIPA') ? 'Matematika & IPA' : (($row->jurusan_mhs == 'Sastra') ? 'Sastra' : '')); ?>" disabled>
                            <label for="inputJurusan">Jurusan</label>
                        </div>
                </div>
                <div class="modal-footer d-flex justify-content-evenly">
                    <h5 class="text-center">Yakin hapus data <?php echo $row->nama_mhs . ' ' . '(' . $row->nim_mhs . ')' ?> ?</h5>
                    <div class="d-inline">
                        <button class="btn btn-secondary" type="button" name="tutup" data-bs-dismiss="modal">Batal</button>
                        <form action="" method="post" class="d-inline text-center">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="_method" value="DELETE">
                            <a href="<?php echo base_url('mahasiswa/hapus/' . $row->id_mhs) ?>" type="submit" class="btn btn-danger">Hapus</a>
                        </form>
                    </div>
                </div>
                </form> <?= form_close(); ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<!-- Modal logout -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">Yakin ingin Logout?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-footer">
                <a class="btn btn-danger col-6 " href="<?= site_url('logout') ?>">Logout</a>
                <button class="btn btn-secondary col-6" type="button" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        // Buat buka modal lewar url (Gangerti cara makenya)
        if (window.location.href.indexOf('#editDataModal' + $id) != -1) {
            $('#editDataModal' + $id).modal('show');
        }

    });

    // Reset warna tombol saat klik close alerts (dah ga kepake)
    function resetColor() {
        var element = document.getElementById("editModalBtn");
        element.classList.remove("btn-secondary");
        var element = document.getElementById("editModalBtn");
        element.classList.add("btn-warning");
    }
</script>

<?= $this->endSection() ?>