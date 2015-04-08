<h3>Kullanıcılar</h3>
<table id="myTable" class="table table-striped">
    <thead>
        <tr>
            <th>Id</th>
            <th>E-Posta</th>
            <th>Ref</th>  
            <th>Durum</th> 
            <th>İşlem</th>   
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
<script type="text/javascript">
    var userTableSource = "<?php echo base_url()?>/kokpit/users/get_data";
</script>