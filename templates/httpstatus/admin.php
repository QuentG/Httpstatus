<?php include(PWD_TEMPLATES . '/incs/head.php'); ?>
<?php include(PWD_TEMPLATES . '/incs/header_admin.php'); ?>

<div class="container">
    <div class="row">
        <h3>List of sites</h3>
        
        <table class="table mt-2">
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">url</th>
                    <th scope="col">status</th>
                    <th scope="col">historic</th>
                    <th scope="col">edit</th>
                    <th scope="col">delete</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td><a href="https://lucasconsejo.fr">https://lucasconsejo.fr</a></td>
                    <td>HTTP : 200</td>
                    <td><a href="./show/1">historic</a></td>
                    <td><a href="./admin/edit">edit</a></td>
                    <td><a href="./admin/delete">delete</a></td>
                </tr>

                <tr>
                    <th scope="row">2</th>
                        <td><a href="http://www.quentingans.fr/">http://www.quentingans.fr/</a></td>
                        <td>HTTP : 200</td>
                        <td><a href="./show/2">historic</a></td>
                        <td><a href="./admin/edit">edit</a></td>
                        <td><a href="./admin/delete">delete</a></td>
                </tr>

                <tr>
                    <th scope="row">3</th>
                    <td><a href="https://axelparis.fr/">https://axelparis.fr/</a></td>
                    <td>HTTP : 200</td>
                    <td><a href="./show/3">historic</a></td>
                    <td><a href="./admin/edit">edit</a></td>
                    <td><a href="./admin/delete">delete</a></td>
                    </tr>
                </tr>
            </tbody>
        </table>
    </div>  
</div>

<?php include(PWD_TEMPLATES . '/incs/footer.php'); ?>