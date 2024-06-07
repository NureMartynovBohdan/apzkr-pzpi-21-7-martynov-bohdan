<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
<?php require "./languages/language.php" ?>
<link rel="stylesheet" href="style.css">
<section class="vh-100" style="background-color: #eee;">
   <div class="container h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
         <div class="col-lg-12 col-xl-11">
            <div class="card text-black" style="border-radius: 25px;">
               <div class="card-body p-md-5">
                  <div class="row justify-content-center">
                     <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                        <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4"><?= $texts['register']; ?></p>
                        <form class="mx-1 mx-md-4" action="registerClient.php" method="POST">

                           <div class="d-flex flex-row align-items-center mb-4">
                              <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                              <div class="form-outline flex-fill mb-0">
                                 <label class="form-label"><?= $texts['name']; ?></label>
                                 <input type="text" name="name" class="form-control" />
                              </div>
                           </div>
                           <div class="d-flex flex-row align-items-center mb-4">
                              <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                              <div class="form-outline flex-fill mb-0">
                                 <label class="form-label"><?= $texts['mail']; ?></label>
                                 <input type="email" name="email" class="form-control" />
                              </div>
                           </div>

                           <div class="d-flex flex-row align-items-center mb-4">
                              <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                              <div class="form-outline flex-fill mb-0">
                                 <label class="form-label"><?= $texts['password']; ?></label>
                                 <input type="password" name="password" class="form-control" />
                              </div>
                           </div>

                           <div class="d-flex flex-row align-items-center mb-4">
                              <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                              <div class="form-outline flex-fill mb-0">
                                 <label class="form-label"><?= $texts['rfid']; ?></label>
                                 <input type="number" name="rfid" class="form-control" />
                              </div>
                           </div>

                           <!-- Стать -->

                           <div class="mb-3">
                              <label for="client_gender" class="form-label"><?= $texts['gender']; ?>:</label>
                              <select class="form-select" id="client_gender" name="client_gender" required>
                                 <option value="Чоловік"><?= $texts['male']; ?></option>
                                 <option value="Жінка"><?= $texts['female']; ?></option>
                              </select>
                           </div>

                           <!-- Верх -->

                           <div class="mb-3 data-part-top" id="size_shoulder">
                              <label for="client_size_shoulder" class="form-label"><?= $texts['shoulder_width']; ?>:</label>
                              <input type="number" class="form-control" id="client_size_shoulder" name="client_size_shoulder">
                           </div>

                           <div class="mb-3 data-part-top" id="size_chest">
                              <label for="client_size_chest" class="form-label"><?= $texts['chest_circumference']; ?>:</label>
                              <input type="number" class="form-control" id="client_size_chest" name="client_size_chest">
                           </div>

                           <div class="mb-3 data-part-top" id="size_sleeve">
                              <label for="client_size_sleeve" class="form-label"><?= $texts['sleeve_length']; ?>:</label>
                              <input type="number" class="form-control" id="client_size_sleeve" name="client_size_sleeve">
                           </div>

                           <!-- Низ -->

                           <div class="mb-3 data-part-down">
                              <label for="client_size_hip" class="form-label"><?= $texts['hip_circumference']; ?>:</label>
                              <input type="number" class="form-control" id="client_size_hip" name="client_size_hip">
                           </div>

                           <div class="mb-3 data-part-down">
                              <label for="client_length_side_seam" class="form-label"><?= $texts['side_seam_length']; ?>:</label>
                              <input type="number" class="form-control" id="client_length_side_seam" name="client_length_side_seam">
                           </div>

                           <!-- Общее -->

                           <div class="mb-3">
                              <label for="client_size_length" class="form-label"><?= $texts['item_length']; ?>:</label>
                              <input type="number" class="form-control" id="client_size_length" name="client_size_length">
                           </div>


                           <!-- error -->
                           <label class="msg d-flex justify-content-center mx-4 mb-3 mb-lg-4" style="color:orangered">
                              <?php
                              echo isset($_SESSION['message_err_reg_client']) ? $_SESSION['message_err_reg_client'] : '';
                              unset($_SESSION['message_err_reg_client']);
                              ?>
                           </label>


                           <!-- succes  -->
                           <label class="msg d-flex justify-content-center mx-4 mb-3 mb-lg-4" style="color:green">
                              <?php
                              echo isset($_SESSION['message_succes']) ? $_SESSION['message_succes'] : '';
                              unset($_SESSION['message_succes']);
                              ?>
                           </label>

                           <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                              <button type="submit" name="submit" class="btn btn-primary btn-lg"><?= $texts['register']; ?></button>
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