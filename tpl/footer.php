	</div>
    </div>

    <footer class="container centered">
        
    </footer>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    
    <script type="text/javascript" src="js/login.js"></script>
    <script type="text/javascript" src="js/delete_toon.js"></script>
    <script type="text/javascript" src="js/schedule.js"></script>
    <script type="text/javascript">
    	$(document).ready(function(){
    		$('#memberlist').dataTable( {
    			"pagingType": "full_numbers",
                "columns": [
                    null, null, null,
                    { "orderable": false },
                    { "orderable": false },
                    { "orderable": false },
                    { "orderable": false },
                    { "orderable": false },
                    { "orderable": false },
                    { "orderable": false },
                    { "orderable": false },
                    { "orderable": false },
                    { "orderable": false },
                    { "orderable": false }
                ]
    		});
    	});
    </script>
  </body>
</html>