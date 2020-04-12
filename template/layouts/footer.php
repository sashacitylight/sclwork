</main>

<script
    src="https://code.jquery.com/jquery-3.4.1.js"
    integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" 
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" 
crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" 
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" 
crossorigin="anonymous"></script>

<script src="https://kit.fontawesome.com/35880850a2.js" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

<script>
    
 $(function() {
      
        $("#btnSubmit").on('hide.bs.modal', function (e) {
                e.preventDefault();
        })
          //валидация формы, сериализация отсылка на AJAX.
        //при нажатии на кнопку с id="save"
        $('#btnSubmit').click( function() {
            event.preventDefault()
            event.stopPropagation()
            var form = $("#myForm");
            
            if (form[0].checkValidity() === false) {
              event.preventDefault()
              event.stopPropagation()
              
              
              form.addClass('was-validated');
              return;
            }
            else
            {
                form.addClass('was-validated');
            }
            
            var url = '/ajaxaddtask/';
            jQuery.ajax({
                url:     url, //url страницы (action_ajax_form.php)
                type:     "POST", //метод отправки
                dataType: "html", //формат данных
                data: form.serialize(),  // Сеарилизуем объект
                success: function(jsonResponse) { //Данные отправлены успешно
                    /*clear очистить модальное окно*/
                    $("#myModal").modal('hide');
                        $('body').on('hidden.bs.modal', '#myModal', function () {
                            $(this).find('form')[0].reset();
                    });
                    $("#myModal").modal('hide');
                    
                    const response = jQuery.parseJSON(jsonResponse);
                    const state    = response.result;
                
                    if ( state == "success" )
                    {
                        Swal.fire({
                            title: 'Отлично!',
                            text: "Задача успешно добавлена!",
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Хорошо!'
                          }).then((result) => {
                                window.location = "/";
                                window.location.href = "/";
				window.location.replace("/");
				location.replace("/");
                          })
                        
                    }
                },
                error: function(response) { // Данные не отправлены
                       // document.getElementById(result_form).innerHTML = "Ошибка. Данные не отправленны.";
                    bootbox.alert("Ошибка!");
                }
            });
            
            return;
      });
      
       $('#form-signin-submit').click( function() {
            event.preventDefault()
            event.stopPropagation()
            var form = $("#form-signin");
            
            if (form[0].checkValidity() === false) {
              event.preventDefault()
              event.stopPropagation()
              
              
              form.addClass('was-validated');
              return;
            }
            else
            {
                form.addClass('was-validated');
            }
            
            var url = '/enter/';
            jQuery.ajax({
                url:     url, //url страницы (action_ajax_form.php)
                type:     "POST", //метод отправки
                dataType: "html", //формат данных
                data: form.serialize(),  // Сеарилизуем объект
                success: function(jsonResponse) { //Данные отправлены успешно
                    
                    const response = jQuery.parseJSON(jsonResponse);
                    const state    = response.result;
                    if ( state == "success" )
                    {
                        Swal.fire({
                            title: 'Отлично!',
                            text: "Вы авторизировались под админом!",
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Хорошо!'
                          }).then((result) => {
                                window.location = "/";
                                window.location.href = "/";
				window.location.replace("/");
				location.replace("/");
                          })
                        
                    }
                    else
                    {
                        $("#wrong-authorization").show().text("Введенные данные не верные!")
                        Swal.fire(
                          'Ошибка! Неправильные реквизиты доступа! ',
                          'Админский доступ не должен быть предоставлен!',
                          'error'
                        )
                    }
                },
                error: function(response) { // Данные не отправлены
                       // document.getElementById(result_form).innerHTML = "Ошибка. Данные не отправленны.";
                    bootbox.alert("Ошибка!");
                }
            });
            
            return;
      });
                
        $('#logout').click( function() {
            event.preventDefault()
            event.stopPropagation()
            
            var url = '/ajaxlogout/';
            jQuery.ajax({
                url:     url, //url страницы (action_ajax_form.php)
                type:     "POST", //метод отправки
                dataType: "html", //формат данных
                success: function(jsonResponse) { //Данные отправлены успешно
                    
                    const response = jQuery.parseJSON(jsonResponse);
                    const state    = response.result;
                    if ( state == "success" )
                    {
                        Swal.fire({
                            title: 'Отлично!',
                            text: "Вы вышли из-под админа!",
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Хорошо!'
                          }).then((result) => {
                                window.location = "/";
                                window.location.href = "/";
				window.location.replace("/");
				location.replace("/");
                          })
                        
                    }
                    else
                    {
                        Swal.fire(
                          'Ошибка! Неверно введены данные! ',
                          'Попробуйте ещё раз!',
                          'error'
                        )
                    }
                },
                error: function(response) { // Данные не отправлены
                       // document.getElementById(result_form).innerHTML = "Ошибка. Данные не отправленны.";
                    bootbox.alert("Ошибка!");
                }
            });
            
        })
      
        $(".task-item-edit-admin__checkbox").click(function(event){
            let $this = $(this)
            let $taskId = $this.closest(".task-item-edit-admin").data("taskId")
            
            let $checked = 0;
            if ( $this.get(0).checked )
            {
                $checked = 1;
            }
            $.post( "/ajaxupdatestatus" , { taskId: $taskId, status: $checked })
            .done( function( response ) 
            {   
                
            });
        })
        
        $(".task-edit-admin").click(function(event){
           
            let $this = $(this)
            let $taskId = $(this).closest(".task-item-edit-admin").data("task-id")
           
            $.post( "/gettask" , { taskId: $taskId })
            .done( function( response ) 
            {   
                $('#myModalEditAdmin').modal({'backdrop': 'static'});
                $("#myFormEdit").html(response)
            });
        })
        
    });    
    
    
    $(document).on("click", "#btnEditTask", function(){
        
        event.preventDefault()
        event.stopPropagation()
        var form = $("#myFormEdit");

        if (form[0].checkValidity() === false) {
          event.preventDefault()
          event.stopPropagation()


          form.addClass('was-validated');
          return;
        }
        else
        {
            form.addClass('was-validated');
        }
        
        var url = '/ajaxupdatetext/';
            jQuery.ajax({
            url:     url, //url страницы (action_ajax_form.php)
            type:     "POST", //метод отправки
            dataType: "html", //формат данных
            data: form.serialize(),  // Сеарилизуем объект
            success: function(jsonResponse) { //Данные отправлены успешно

                const response = jQuery.parseJSON(jsonResponse);
                const state    = response.result;
                if ( state == "success" )
                {
                    
                    window.location = "<?=$_SERVER["REQUEST_URI"]?>";
                    window.location.href = "<?=$_SERVER["REQUEST_URI"]?>";
                    window.location.replace("<?=$_SERVER["REQUEST_URI"]?>");
                    location.replace("<?=$_SERVER["REQUEST_URI"]?>");
                     

                }
                else if ( state == "notauthorized" )
                {
                    Swal.fire(
                      'Вы не авторизировались! ',
                      'Авторизируйтесь!',
                      'error'
                    )
                }
                else
                {
                    Swal.fire(
                      'Ошибка! Неверно введены данные! ',
                      'Попробуйте ещё раз!',
                      'error'
                    )
                }
            },
            error: function(response) { // Данные не отправлены
                   // document.getElementById(result_form).innerHTML = "Ошибка. Данные не отправленны.";
                bootbox.alert("Ошибка!");
            }
        });
        
    })
</script>


</body>
</html>