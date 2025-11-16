    <!-- jQuery (already included where needed) -->
    <script src="/assets/bootstrap/js/jquery-1.12.0.min.js"></script>
    <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="/assets/bootstrap/js/jquery.dataTables.min.js"></script>
    <script src="/assets/LTE/js/app.min.js"></script>
    <script src="/custom.js"></script>
    <script>
      $(function () {
        if (window.$ && $.fn.DataTable) {
          $("#example1").DataTable();
          $('#example2').DataTable({
            "paging": false,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false
          });
        }
      });
    </script>

</body>
</html>
