/**
 * Created by dell3542 on 6/24/15.
 */

$(document).ready(function(){
    $('#userform').hide();
    $('#adduser').click(function(){
        $('#userform').slideToggle('fast').append(function(){
        });
    });
    $( ".datepicker" ).datepicker();
    $( ".datepick" ).datepicker();

    $('#checkAll').click(function(){
        $("input:checkbox").prop('checked',true);
    });

    $('#uncheckAll').click(function(){
        $("input:checkbox").prop('checked',false);
    });

    $('#changePasswordArea').hide();
    $('#changeDetails').hide();

    $('#changePassword').click(function(){
        $('#changeDetailsArea').fadeOut('fast').append(function(){
            $('#changePasswordArea').fadeIn('fast');
            $('#changeDetails').show();
            $('#changePassword').hide();
        });
    });

    $('#changeDetails').click(function(){
        $('#changePasswordArea').fadeOut('fast').append(function(){
            $('#changeDetailsArea').fadeIn('fast');
            $('#changePassword').show();
            $('#changeDetails').hide();
        });
    });

    $('#date-chooser').hide();
    $('#category').change(function(){
        var select = $('#category :selected').text();
        if(select == 'Attendance'){
            $('#date-chooser').show();
        }else{
            $('#date-chooser').hide();
        }
    });

    $('#date1').change(function(){
        var abc=$('#date1');
        var checkbox=$('#checkbox');
        checkbox.empty();
        $.ajax({
            method: "GET",
            url: "/a",
            dataType:'json',
            data: { date: abc.val()},
            success:function(result){
                console.log(result);
                result.forEach(function(data){
                     checkbox.append('<input type="checkbox" name="empName[]" value="+data.id+"><label>&nbsp;'+ data.first_name + ' ' + data.middle_name + ' ' + data.last_name + ' [User ID: ' + data.id +']</label><br>');
                });
            }
        });

        });
    $('.datepicker').change(function(){
       var value=$('.datepicker');
            var date=[];
        var i=0;
        value.each(function(){
            if($(this).val()==''){
//                alert('Please Enter Date');
            }
            else{
                date[i]=$(this).val();
                i++;
            }
        });
        if(date[1]!=undefined){
            $.ajax({
                method: "GET",
                url: "/b",
                dataType:'json',
                data: { date:date[0],date1:date[1]},
                success:function(result){
                    console.log(result);
//                    result.forEach(function(data){
//                        checkbox.append('<input type="checkbox" name="empName[]" value="+data.id+"><label>&nbsp;'+ data.first_name + ' ' + data.middle_name + ' ' + data.last_name + ' [User ID: ' + data.id +']</label><br>');
//                    });
                }
            });

        }
    });

});


$(function(){
   $(".nav-top1").hover(function(){
        $(".nav-child1").addClass("change_nav-child");
    },function(){
        $(".nav-child1").addClass("unchange_nav-child");
   });
});
