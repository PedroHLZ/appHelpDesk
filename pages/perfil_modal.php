<!-- Logout Modal-->
<div class="modal fade" id="perfil_usuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content bg_tranparent">
            <div class="modal-body">
                <div class="align-items-center row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                        <div class="pt-20 rounded-top"></div>
                        <div class="rounded smooth-shadow-sm " style="background: url(<?php echo $enderecodosite; ?>/user_img/profile-cover.jpg) 0% 0% / cover no-repeat;">
                            <div class="d-flex align-items-center justify-content-between pt-4 pb-6 px-4 flex-wrap">
                                <div class="me-3 p-3 position-relative d-flex align-items-end mt-n10">
                                    <img src="<?php echo $enderecodosite; ?>/user_img/<?php echo $foto_perfil; ?>" alt="" class="avatar-xxl rounded-circle border border-4 border-white-color-40" style="width: 100px; height: 100px; object-fit: cover;">
                                </div>
                                <div class="lh-1 flex-grow-1">
                                    <h2 class="mb-1" style="color: aliceblue;"><?php echo $nome_do_usuario; ?><a class="text-decoration-none" data-bs-toggle="tooltip" data-placement="top"></a></h2>
                                    <p class="mb-3" style="color: aliceblue;"><?php echo $email_do_usuario; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- jQuery e Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>