<style>
    div.dataTables_wrapper div.dataTables_filter label{float: right;}
</style>
<table id="datatable-buttons1"  class="table table-borderless white-space-wrap syllabuslistvie">
                            <thead>
                                <tr>
                                    <th>Sr No.</th>
                                    <th>Syllabus For</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $j=1;
                                foreach ($syllabuslist as $i => $helpData) {
                                    $Stype = getData("tb_class",array('title'),'class_id',$helpData['s_for']);
                                ?>
                                <tr>
                                    <td><?= $j ?></td>
                                    <td><?php echo (count($Stype)>0) ? $Stype[0]['title'] : '';?></td>
                                    <td><?php
                                       $explode = explode(" ", $helpData['description']);     
                                       foreach ($explode as $key1 => $value1) {
                                           if($key1==20){
                                             break;
                                           }else{
                                             echo $value1." ";
                                           }
                                       }
                                    ?></td>
                                    <td class="d-flex op1">
                                        <a href="<?= base_url() ?>Ct_syllabus/edit/<?= $helpData['sl_id'] ?>" class="btn btn-sm btn-primary btn-inline p-0" data-toggle="tooltip" data-placement="top" data-original-title="Edit">&nbsp;<i class="fa fa-edit"></i>&nbsp;</a>
                                        <a class="btn btn-sm btn-primary btn-inline  ml-2 p-0 " onclick="deleteSyllabus('<?php echo $helpData['sl_id']; ?>')" data-toggle="tooltip" data-placement="top" data-original-title="Delete">&nbsp;<i class="fa fa-trash"></i>&nbsp;</a>
                                    </td>
                                </tr>
                                <?php
                                    $j++;
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                        
                                    </tfoot>
                        </table>

<script type="text/javascript">
    $("#datatable-buttons1").dataTable({
        "scrollX": true,
            "autoWidth": false,
            "columnDefs": [ {
                            "targets": 0,
                            "orderable": false
                            },
                            { "width": "50px", "targets": 0 },
                            { "width": "100px", "targets": 1 },
                            { "width": "400px", "targets": 2 },
                            { "width": "100px", "targets": 3 }
            ],
        "dom" : "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            //"bAutoWidth": true,
            "scrollX": true,      
            "order": [[ 0, "desc" ]],
            "lengthMenu": [[10, 10, 25, 50], ["10", 10, 25 ,50]],
            oLanguage: {
                sLengthMenu: "_MENU_",
            },
            "language": {                
                "infoFiltered": ""
            },
        stateSave : true,
         initComplete: function () {
            var main = '<select class="custom-select custom-select-sm fclass">';
            main +='<option value="all" <?php if($fclass=='all') echo "selected"; ?>>All</option>';
            <?php
            foreach ($classList as $key => $value) {
            ?>
            main +='<option value=<?php echo $value['class_id']; ?> <?php if($fclass==$value['class_id']) echo "selected"; ?>><?php echo $value['title']; ?></option>';
            <?php
            }
            ?>
            main +='</select>';
            $("#datatable-buttons1_filter").append(main);
         }
    });

    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();   
    });
</script>