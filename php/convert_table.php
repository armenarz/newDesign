<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>VARCHAR to BLOB, TEXT to BLOB converter</title>
  </head>
  <body>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        
            <div class="container-fluid">
                <div class="row">
                <div class="col-lg-7">
                    <fieldset class="form-group border rounded mt-4 pb-4 px-4 d-print-none">
                    <legend class="form-control px-2 w-auto"><strong>Заполните исходные данные для выполнения конвертации.</strong></legend>
                        <div class="row">
                            <div class="col-lg-3">
                                <label for="table_name">Название таблицы</label>
                                <input class="form-control" type="text" name="table_name"/>
                            </div>
                            <div class="col-lg-3">
                                <label for="table_id">Уникальный ключ (primary key)</label>
                                <input class="form-control" type="text" name="table_id"/>
                            </div>
                            <div class="col-lg-4">
                                <label for="fields">Поля (перечислите разделяя запятыми)</label>
                                <input class="form-control" type="text" name="fields"/>
                            </div>
                            <div class="col-lg-2">
                                <label for="submit">&nbsp;</label>
                                <input class="form-control" type="submit" name="submit" value="Convert"/>
                            </div>

                        </div>
                    </fieldset>
                </div>
                <div class="col-lg-5"></div>
                </div>         
            </div>
        
    </form>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
<?php
//require_once("connect_admin.php");
require_once("connect.php");
if(isset($_POST["submit"]))
{
    if(!isset($_POST["table_name"]))
    {
        echo "Table name is not set";
        return;
    }
    else
    {
        $table_name = $_POST["table_name"];
        if($table_name == "")
        {
            echo "Table name is not set";
            return;
        }

    }

    if(!isset($_POST["table_id"]))
    {
        echo "Table id is not set";
        return;
    }
    else
    {
        $table_id = $_POST["table_id"];
        if($table_id == "")
        {
            echo "Table id is not set";
            return;
        }
    }

    if(!isset($_POST["fields"]))
    {
        echo "Fields are not set";
        return;
    }
    else
    {
        $fields = explode(",",$_POST["fields"]);
        if(count($fields)==0)
        {
            echo "Fields are not set";
            return;
        }
    }
}
else
{
    return;
}

echo "Table ".$table_name."<br/>";

foreach($fields as $field)
{
    //ALTER TABLE table_name ADD temp BLOB NOT NULL AFTER field_name
    $sql = "ALTER TABLE ".$table_name." ADD temp BLOB NULL AFTER ".$field;
    $result = mysqli_query($link,$sql);
    if(!$result)
    {
        echo mysqli_error($link);
        return;
    }

    $sql = "SELECT * FROM ".$table_name;
    $result = mysqli_query($link,$sql);
	if(!$result)
    {
        echo mysqli_error($link);
        return;
    }
    while($row = mysqli_fetch_array($result))
    {
        $id = $row[$table_id];
        $field_value = $row[$field];
        //UPDATE table_name SET temp = field_value WHERE table_id = id
        $sql_update =  "UPDATE ".$table_name." SET temp = '".$field_value."' WHERE ".$table_id."='".$id."'";
        $result_update = mysqli_query($link,$sql_update);
        if(!$result_update)
        {
            echo mysqli_error($link);
            return;
        }
    }

    //ALTER TABLE table_name DROP field_name
    $sql = "ALTER TABLE ".$table_name." DROP ".$field;
    $result = mysqli_query($link,$sql);
    if(!$result)
    {
        echo mysqli_error($link);
        return;
    }

    //ALTER TABLE table_name ADD field_name BLOB NOT NULL AFTER temp 
    $sql = "ALTER TABLE ".$table_name." ADD ".$field." BLOB NULL AFTER temp";
    $result = mysqli_query($link,$sql);
    if(!$result)
    {
        echo mysqli_error($link);
        return;
    }    
    
    //UPDATE table_name SET field_name = temp
    $sql = "UPDATE ".$table_name." SET ".$field." = temp";
    $result = mysqli_query($link,$sql);
    if(!$result)
    {
        echo mysqli_error($link);
        return;
    }

    //ALTER TABLE table_name DROP temp
    $sql = "ALTER TABLE ".$table_name." DROP temp";
    $result = mysqli_query($link,$sql);
    if(!$result)
    {
        echo mysqli_error($link);
        return;
    }

    echo "The field ".$field." is successfully converted. <br/>";
}
?>