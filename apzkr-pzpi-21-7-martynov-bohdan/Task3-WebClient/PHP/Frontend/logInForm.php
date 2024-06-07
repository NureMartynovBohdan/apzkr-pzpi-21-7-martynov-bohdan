<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
<?php require "./languages/language.php" ?>
<section class="vh-100" style="background-color: #eee;">
   <div class="container h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
         <div class="col-lg-12 col-xl-11">
            <div class="card text-black" style="border-radius: 25px;">
               <div class="card-body p-md-5">
                  <div class="row justify-content-center">
                     <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                        <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4"><?= $texts['login']; ?></p>
                        <form class="mx-1 mx-md-4" action="logIn.php" method="POST">

                           <div class="d-flex flex-row align-items-center mb-4">
                              <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                              <div class="form-outline flex-fill mb-0">
                                 <label class="form-label"><?= $texts['mail']; ?></label>
                                 <input type="email" name="user_email" class="form-control" />
                              </div>
                           </div>

                           <div class="d-flex flex-row align-items-center mb-4">
                              <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                              <div class="form-outline flex-fill mb-0">
                                 <label class="form-label"><?= $texts['password']; ?></label>
                                 <input type="password" name="password" class="form-control" />
                              </div>
                           </div>

                           <label class="msg d-flex justify-content-center mx-4 mb-3 mb-lg-4" style="color:orangered">
                              <?php
                              $errorMessage = '';

                              if (isset($_SESSION['message_err_log_pass'])) {
                                 $errorMessage .= $_SESSION['message_err_log_pass'];
                                 unset($_SESSION['message_err_log_pass']);
                              }

                              if (isset($_SESSION['message_err_log_email'])) {
                                 $errorMessage .= $_SESSION['message_err_log_email'];
                                 unset($_SESSION['message_err_log_email']);
                              }

                              echo $errorMessage;
                              ?>
                           </label>




                           <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                              <button type="submit" name="submit" class="btn btn-primary btn-lg"><?= $texts['login']; ?></button>
                           </div>

                        </form>

                     </div>

                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>