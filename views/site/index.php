<?php
$currentpage    = $data["currentpage"];
$range          = $data["range"];
$totalpages     = $data["totalpages"];
$modelTasks     = $data['modelTasks'];
$sortField      = $data["sortField"];
$sortFieldValue = $data["sortFieldValue"];


?>

<section id="tasks-content">
    <div class="my-3 p-3 bg-white rounded shadow-sm">

        <div class="row mt-3">
            <div class="col">
                <div class="d-flex justify-content-lg-end">
                    <!-- Extra large modal -->
                    <button onclick="$('#myModal').modal({'backdrop': 'static'});" type="button" 
                            class="tasks-content__btn-add btn btn-primary" >
                        <i class="fas fa-plus"></i> Добавить новую задачу
                    </button>
                  
                </div>
            </div>
        </div>

        <div class="row header-list border-bottom border-gray py-1 m-1 no-gutters">
            <div class="col-lg-4 col-md-4 col-sm-12"> 
                <div class="header-list__item" id="header-list__item-username">
                    <?php if ( $sortField == "username" ) : ?>
                        <a href="/site/<?= $currentpage ?>/username/<?= $sortFieldValue ?>/1">Имя пользователя </a>

                        <?php if ( $sortFieldValue == "ASC" ) : ?>
                            <i class="fas fa-angle-up" aria-hidden="true"></i>
                        <?php elseif ( $sortFieldValue == "DESC" ) : ?>
                            <i class="fas fa-angle-down"></i>
                        <?php endif; ?>
                    <?php else: ?>
                        <a href="/site/<?= $currentpage ?>/username//1">Имя пользователя </a>  
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12">  
                <div class="header-list__item" id="header-list__item-mail">
                    <?php if ( $sortField == "email" ) : ?>
                        <a href="/site/<?= $currentpage ?>/email/<?= $sortFieldValue ?>/1">E-mail </a>
                        <?php if ( $sortFieldValue == "ASC" ) : ?>
                            <i class="fas fa-angle-up" aria-hidden="true"></i>
                        <?php elseif ( $sortFieldValue == "DESC" ) : ?>
                            <i class="fas fa-angle-down"></i>
                        <?php endif; ?>
                    <?php else: ?>
                        <a href="/site/<?= $currentpage ?>/email//1">E-mail </a> 
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12"> 
                <div class="header-list__item"  id="header-list__item-status">

                    <?php if ( $sortField == "status" ) : ?>
                        <a href="/site/<?= $currentpage ?>/status/<?= $sortFieldValue ?>/1">Статус </a>
                        <?php if ( $sortFieldValue == "ASC" ) : ?>
                            <i class="fas fa-angle-up" aria-hidden="true"></i>
                        <?php elseif ( $sortFieldValue == "DESC" ) : ?>
                            <i class="fas fa-angle-down"></i>
                        <?php endif; ?>
                    <?php else: ?>
                        <a href="/site/<?= $currentpage ?>/status//1">Статус </a>
                    <?php endif; ?>
                </div>


            </div>
        </div>

        <?php if ( ! empty( $data['modelTasks'] ) ) : ?>
            <?php foreach ( $data['modelTasks'] as $taskItem ) : ?>
                <div class="task-item media text-muted pt-3">
                    <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                        <strong class="task-item__username text-gray-dark"><?= $taskItem["task__username"] ?></strong>
                        <span class="task-item__mail d-block"><?= $taskItem["task__email"] ?></span>
                        <span class="task-item__text"><?= $taskItem["task__text"] ?></span>
                        <?php if ( $taskItem["task__status"] ) : ?>
                            <span class="task-item__status mt-3 d-block badge badge-success ">Выполнено</span>
                        <?php else : ?>    
                            <span class="task-item__status mt-3 d-block badge badge-warning">Не выполнено</span>
                        <?php endif; ?>
                            
                        <?php if ( $taskItem["task__adminedited"] ) : ?>
                            <span class="task-item__admin-edited mt-3 d-block badge badge-info ">Отредактировано администратором</span>
                        <?php endif; ?>  
                    </p>
                </div>
        
                <?php if ( isset( $_SESSION["is_admin"] ) && !empty( $_SESSION["is_admin"] ) ) : ?>
                <div class="task-item-edit-admin py-3 border-bottom" data-task-id="<?=$taskItem["task__id"]?>">
                    <button   type="button" class="task-edit-admin btn btn-secondary btn-sm"><i class="fas fa-edit"></i> Редактировать</button>
                    <div class="form-group pt-2 mb-0">
                        <div class="form-check">
                            <?php if ( $taskItem["task__status"] ) : ?>
                                <input class="task-item-edit-admin__checkbox form-check-input" type="checkbox" id="gridCheck" checked>
                            <?php else : ?>
                                 <input class="task-item-edit-admin__checkbox form-check-input" type="checkbox" id="gridCheck" >
                            <?php endif; ?>
                            <label class="form-check-label " for="gridCheck">
                              Выполнена
                            </label>
                        </div>
                    </div>
                </div>
                <?php endif;?>
        
            <?php endforeach; ?>
        <?php endif; ?>

        
        
        
        <div class="row">
            <div class="col-12 col-md-7 col-lg-7">
                <div class="task-pagination bd-example my-4">
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <?php
                            /*                             * ****  пагинация ***** */
                            // формируем ссылки на первую и предыдущую страницу
                            if ( $currentpage > 1 )
                            {
                                echo " <li class='page-item'><a class='page-link' href='/site/1/$sortField/$sortFieldValue/'>Первая</a><li>";
                                $prevpage = $currentpage - 1;
                                echo " <a class='page-link' href='/site/$prevpage/$sortField/$sortFieldValue/'><<</a> ";
                            } else
                            {
                                echo " <li class='disabled'><a class='page-link' href='/site/1/$sortField/$sortFieldValue/'>Первая</a><li>";
                                $prevpage = $currentpage - 1;
                                echo " <li class='disabled'><a class='page-link' href='/site/$prevpage/$sortField/$sortFieldValue/'><<</a></li> ";
                            }
                            // цикл, с помощью которого отобразим пагинацию (вокруг текущей страницы)
                            for ( $x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x ++ )
                            {
                                // если номер страницы верный...
                                if ( ($x > 0) && ($x <= $totalpages) )
                                {
                                    // если страница текщая...
                                    if ( $x == $currentpage )
                                    {
                                        // вывод текущей страницы
                                        echo "  <li class='page-item active'><a class='page-link' href='/site/$sortField/$sortFieldValue/'>$x</a></li>";
                                        // если страница не текущая...
                                    } else
                                    {
                                        // вывод не текущей страницы
                                        echo " <li class='page-item'><a class='page-link' href='/site/$x/$sortField/$sortFieldValue/'>$x</a></li> ";
                                    }
                                }
                            }

                            // формируем ссылки на последнюю и следующую страницу     
                            if ( $currentpage != $totalpages )
                            {
                                $nextpage = $currentpage + 1;
                                echo " <li class='page-item'><a class='page-link' href='/site/$nextpage/$sortField/$sortFieldValue/'>>></a><li> ";
                                echo " <li class='page-item'><a class='page-link' href='/site/$totalpages/$sortField/$sortFieldValue/'>Последняя</a><li> ";
                            } else
                            {
                                $nextpage = $currentpage + 1;
                                echo " <li class='disabled'><a class='page-link' href='/site/$nextpage/$sortField/$sortFieldValue/'>>></a><li> ";
                                echo " <li class='disabled'><a class='page-link' href='/site/$totalpages/$sortField/$sortFieldValue/'>Последняя</a><li> ";
                            }
                            ?>
                        </ul>
                    </nav>
                </div>
            </div>

            <div class="col col-12 col-md-5 col-lg-5 my-4">
                <div class="d-flex justify-content-lg-end">
                    <!-- Extra large modal -->
                    <button onclick="$('#myModal').modal({'backdrop': 'static'});"  type="button" class="tasks-content__btn-add btn btn-primary">
                        <i class="fas fa-plus"></i> Добавить новую задачу
                    </button>
                </div>
            </div>

        </div>
        
        
        <div class="row">
            <div class="col-12 col-md-5 col-lg-5">
            <div class="d-flex align-items-center justify-content-lg-begin">
                <?php if ( isset( $_SESSION["is_admin"] ) && !empty( $_SESSION["is_admin"] ) ) : ?>
                    <button id="logout" class="btn-admin-login btn btn-dark my-4" ><i class="fas fa-sign-in-alt"></i> Выйти из под администратора</button>
                <?php else: ?>
                    <a href="/enter" class="btn-admin-login btn btn-dark my-4" ><i class="fas fa-sign-in-alt"></i> Вход для администратора</a>
                <?php endif; ?>

            </div>
            </div>
        </div>
        
    </div>
   

</section>



<div id="myModal" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        
        
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

              <div class="modal-header">
                <h5 class="modal-title h4" id="myLargeModalLabel">Добавление задачи</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
              <div class="modal-body">
                <form id="myForm">
                    
                    <div class="form-group">
                        <label for="validationDefault01">Имя пользователя</label>
                        <input name="username" type="text" class="form-control" id="validationDefault01" value="" required>
                        <div class="valid-feedback">
                            Успешно заполнено!
                        </div>
                        <div class="invalid-feedback">Не заполнено! </div>
                    </div>
                    
                    
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Email адрес</label>
                        <input name="email" type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com" required>
                        <div class="valid-feedback">
                            Успешно заполнено!
                        </div>
                        <div class="invalid-feedback">Email не валиден! </div>
                    </div>
                   
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Текст задачи</label>
                        <textarea name="text" class="form-control" id="exampleFormControlTextarea1" rows="3" required></textarea>
                        <div class="valid-feedback">
                            Успешно заполнено!
                        </div>
                        <div class="invalid-feedback">Не заполнено! </div>
                      
                    </div>
                    
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Статус задачи</label>
                        <select name="status" class="form-control" id="exampleFormControlSelect1">
                          <option value="0">Не выполнена</option>
                          <option value="1">Выполнена</option>
                        </select>
                    </div>
                    
                    <button id="btnSubmit" type="submit" class="btn btn-primary"><i class="far fa-plus-square"></i> Добавить </button>
                </form>
              </div>
            </div>
          </div>
    </div>
</div>



<div id="myModalEditAdmin" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        
        
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

              <div class="modal-header">
                <h5 class="modal-title h4" id="myLargeModalLabel">Обновление задачи</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
              <div class="modal-body">
                
                  <form id="myFormEdit">
                    
                    <div class="form-group">
                        <label for="validationDefault01">Имя пользователя</label>
                        <input name="username" type="text" class="form-control" id="validationDefault01" value="" required>
                        <div class="valid-feedback">
                            Успешно заполнено!
                        </div>
                        <div class="invalid-feedback">Не заполнено! </div>
                    </div>
                    
                    
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Email адрес</label>
                        <input name="email" type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com" required>
                        <div class="valid-feedback">
                            Успешно заполнено!
                        </div>
                        <div class="invalid-feedback">Email не валиден! </div>
                    </div>
                   
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Текст задачи</label>
                        <textarea name="text" class="form-control" id="exampleFormControlTextarea1" rows="3" required></textarea>
                        <div class="valid-feedback">
                            Успешно заполнено!
                        </div>
                        <div class="invalid-feedback">Не заполнено! </div>
                      
                    </div>
                    
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Статус задачи</label>
                        <select name="status" class="form-control" id="exampleFormControlSelect1">
                          <option value="0">Не выполнена</option>
                          <option value="1">Выполнена</option>
                        </select>
                    </div>
                    
                    <button id="btnSubmit" type="submit" class="btn btn-primary"><i class="far fa-save"></i> Сохранить </button>
                </form>
              </div>
            </div>
          </div>
    </div>
</div>




