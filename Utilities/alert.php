<?php
function alert($icon,$title,$text,$location){
    echo "
        <script type='text/javascript'>
            Swal.fire({
            // showDenyButton: true,
            // showCancelButton: true,
            icon: '$icon',
            title: '$title',
            text: '$text',
            // footer: '<a href='>Why do I have this issue?</a>'
            }).then(function() {
                window.location = '$location';
            });
        </script>
    ";
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>SweetAlert</title>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

</body>
</html>