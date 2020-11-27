<table id="datatable-buttons1"  class="table nowrap">
                            <thead>
                                <tr>
                                    <th>Sr No.</th>
                                    <th>Support Type</th>
                                    <th>Title</th>
                                    <th>Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $j=1;
                                foreach ($helpList as $i => $helpData) {
                                    $Stype = getData("tb_help",array('title'),'help_id',$helpData['helpid']);
                                ?>
                                <tr>
                                    <td><?= $j ?></td>
                                    <td><?php echo (count($Stype)>0) ? $Stype[0]['title'] : '';?></td>
                                    <td class="white-space-wrap"><a href="<?= base_url() ?>Ct_help/edit/<?= $helpData['hsub_id'] ?>"><?= $helpData['title'] ?></a></td>
                                    <td><?php echo ($helpData['htype']=="1") ? 'Article' : 'Video'; ?></td>
                                    <td class="op1">
                                        <a href="<?= base_url() ?>Ct_help/edit/<?= $helpData['hsub_id'] ?>" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" data-original-title="Edit">&nbsp;<i class="fa fa-edit"></i>&nbsp;</a>
                                        <a class="btn btn-sm btn-primary" onclick="removeHelp('<?php echo $helpData['hsub_id']; ?>')" data-toggle="tooltip" data-placement="top" data-original-title="Delete">&nbsp;<i class="fa fa-trash"></i>&nbsp;</a>
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
        "dom" : "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            "bAutoWidth": true,
            "scrollX": true,      
            // "order": [[ 0, "desc" ]],
            "lengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
            oLanguage: {
                sLengthMenu: "_MENU_",
            },
            "language": {                
                "infoFiltered": ""
            },
            "columnDefs": [
                { "width": "8%", "targets": 0 },
                { "width": "20%", "targets": 1 },
                { "width": "30%", "targets": 2 },
                { "width": "20%", "targets": 3 },
                { "width": "20%", "targets": 0 },
            ],
        // stateSave : true,
         initComplete: function () {
            var main = '<select class="custom-select custom-select-sm fhelp" style="float:left; width: auto;max-width: inherit;">';
            main +='<option value="all" <?php if($ftype=='all') echo "selected"; ?>>All</option>';
            <?php
            foreach ($mainHelp as $key => $value) {
            ?>
            main +='<option value=<?php echo $value['help_id']; ?> <?php if($ftype==$value['help_id']) echo "selected"; ?>><?php echo $value['title']; ?></option>';
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