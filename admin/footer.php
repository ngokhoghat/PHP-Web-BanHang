<!-- Footer -->
<footer class="sticky-footer bg-white">
  <div class="container my-auto">
    <div class="copyright text-center my-auto">
      <span>Copyright &copy; Your Website 2019</span>
    </div>
  </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
  <i class="fas fa-angle-up"></i>
</a>


<!-- Bootstrap core JavaScript-->
<script src="public/vendor/jquery/jquery.min.js"></script>
<script src="public/vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="public/js/sb-admin-2.min.js"></script>

<script src="public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="public/tinymce/tinymce.min.js"></script>
<script src="public/tinymce/config.js"></script>
<script type="text/javascript" src="public/autoNumeric/autoNumeric-2.0-BETA.js"></script>
<script>
  $('#view-order .price').autoNumeric("init", {
    aSign: ' đ',
    pSign: 's',
    mDec: '0'
  });
  $('#order-price .price').autoNumeric("init", {
    aSign: ' đ',
    pSign: 's',
    mDec: '0'
  });
</script>
<script>
  $("input#anh_phu").change(function() {
    var _file = $(this).prop('files');

    if (_file) {
      for (var i = 0; i < _file.length; i++) {
        let _r = new FileReader();

        _r.onload = function(e) {

          var _img_src = e.target.result;
          var img = document.createElement("img");
          img.className = "col-md-4 img-fluid h-100 mb-2";
          img.src = _img_src;
          $("#img_list").append(img);
        }
        _r.readAsDataURL(_file[i]);
      }

    }
  });
</script>


</body>



</html>