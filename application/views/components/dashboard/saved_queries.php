<!-- Saved Queries -->
<?php if (!empty($config->setting_saved_queries) && $saved_query_dashboard->rowCount() > 0): ?>
    <?php while($table = $saved_query_dashboard->fetch()): ?>
        <?php $this->query->set_database($this->db->database()); ?>
        <?php $query = $this->query->get_saved_query($table->id, $this->database); ?>

        <div class="column-card mb-5">
            <div class="card-header mb-0 pb-0">
                <div class="card-title"><h6><?php echo $table->name; ?></h6></div>
            </div>
            <div class="card-body">
                <div class="table-responsive">

                    <table id="edit-table" class="table table-striped table-bordered">
                        <?php
                            
                            echo '<thead><tr class="table-primary">';

                            for ($i = 0; $i < $query->columnCount(); $i++) {
                                $col = $query->getColumnMeta($i);

                                echo '<th>' . $col['name'] . '</th>';
                            }

                            echo '</tr></thead><tbody>';

                            for ($j = 0; $j < $query->rowCount(); $j++) {
                                $row = $query->fetch(PDO::FETCH_ASSOC);

                                $primary_key = $foreign_key = $pkey_val = $fkey_val = '';
                                echo '<tr>';

                                for ($k = 0; $k < $query->columnCount(); $k++) {
                                    $col = $query->getColumnMeta($k);

                                    if (in_array('primary_key', $col['flags']) == TRUE) {
                                        $primary_key = $col['name'];
                                        $pkey_val = $row[$col['name']];
                                    }

                                    if (in_array('multiple_key', $col['flags']) == TRUE) {
                                        $foreign_key = $col['name'];
                                        $fkey_val = $row[$col['name']];
                                    }

                                    if (!empty($pkey_val) && !empty($fkey_val)) {
                                        if ($col['native_type'] == "BLOB") {
                                            echo '<td><a href="'.site_url('query/saved_query/'.$table->id.'/'.$pkey_val.'/'.$fkey_val).'" class="text-dark table-link">'.get_summary($row[$col['name']], config('summary_sentence_limit')).'</a></td>';
                                        }
                                        else {
                                            echo '<td><a href="'.site_url('query/saved_query/'.$table->id.'/'.$pkey_val.'/'.$fkey_val).'" class="text-dark table-link">'.$row[$col['name']].'</a></td>';
                                        }
                                    }
                                    else {
                                        if ($col['native_type'] == "BLOB") {
                                            echo '<td><a href="'.site_url('query/saved_query/'.$table->id.'/'.$pkey_val).'" class="text-dark table-link">'.get_summary($row[$col['name']], config('summary_sentence_limit')).'</a></td>';
                                        }
                                        else {
                                            echo '<td><a href="'.site_url('query/saved_query/'.$table->id.'/'.$pkey_val).'" class="text-dark table-link">'.$row[$col['name']].'</a></td>';
                                        }
                                    }
                                }

                                echo '</tr>';
                            }

                            echo '</tbody>';
                        ?>
                    </table>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
<?php endif; ?>
<!-- End Saved Queries -->