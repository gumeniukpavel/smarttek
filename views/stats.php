<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Stats</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
    <a href="/">Home</a>
    <div class="row">
        <?php if (isset($error)) { ?>
            <h1 class="text-center"><?=$error?></h1>
        <?php } else { ?>
            <h1 class="text-center">Stats</h1>
            <div class="col-12">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Customer ID</th>
                        <th scope="col">Number of customer's calls within same continent</th>
                        <th scope="col">Total duration of customer's calls within same continent</th>
                        <th scope="col">Number of all customer's calls</th>
                        <th scope="col">Total duration of all customer's calls</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($response as $id => $data) { ?>
                        <tr>
                            <th scope="row"><?= $id ?></th>
                            <td><?= $data['numbers'] ?></td>
                            <td><?= $data['duration'] ?></td>
                            <td><?= $data['totalNumbers'] ?></td>
                            <td><?= $data['totalDuration'] ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>
    </div>
</div>
</body>
</html>