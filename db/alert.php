<!-- ?php //if (isset($_SESSION['errorMessage'])): ?>
    <div class="alert alert-<= $_SESSION['errorType'] ?> alert-dismissible fade show rounded rounded-0 m-0" role="alert">
        <strong><= $_SESSION['errorHead'] ?></strong> <= $_SESSION['errorMessage']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    ?php unset($_SESSION['errorHead']);
    unset($_SESSION['errorType']);
    unset($_SESSION['errorMessage']); ?> -->
<?php
if (isset($_SESSION['errorMessage'])): ?>
    <!-- Modal HTML -->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content mid-accent-bg">
          <div class="modal-header border-0 justify-content-center pb-2">
        <h1>
        <?php if ($_SESSION['errorType']=="danger"): ?>
    <!-- Show X icon for error -->
    <i class="bi bi-x-circle-fill text-danger"></i>
<?php else: ?>
    <!-- Show check icon for success -->
    <i class="bi bi-check-circle-fill dark-accent-fg"></i>
<?php endif; ?>
            </h1>
          </div>
          <div class="modal-body border-0 text-center pt-0">
          <h3 class="modal-title lilita" id="errorModalLabel"><?= $_SESSION['errorHead'] ?></h3>
            <?= $_SESSION['errorMessage']; ?>
          </div>
          <div class="modal-footer border-0 justify-content-center">
            <button type="button" class="btn rounded-0 dark-accent-bg text-white lilita" data-bs-dismiss="modal">DONE</button>
          </div>
        </div>
      </div>
    </div>
    
    <!-- JavaScript to show modal -->
    <script>
      var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
      errorModal.show();
    </script>
    
    <?php
    unset($_SESSION['errorHead']);
    unset($_SESSION['errorType']);
    unset($_SESSION['errorMessage']);
    endif; ?>
    