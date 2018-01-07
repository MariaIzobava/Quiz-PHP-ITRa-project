; (function($) {

        $.fn.ajaxGrid = function(options) {
            
            $(".table").on("click", "tfoot button", function(e) {
                var number = parseInt($.trim($(this).siblings("span").text()));
                console.log(number);
                if ($(this).hasClass("left")) 
                    number--;
                else 
                    number++;
                if (number == 0) return;
                var field = null;
                var text_search = null;
                $(this).closest("table").find("thead input").each(function() {
                    if ($(this).val() != "") {
                        text_search = $(this).val();
                        field = $(this).closest("th").attr('name');
                        return;
                    }
                    
                });
                
                var newDirect = $(".table").attr("direct");
                var col = $(".table").attr("column");
                
                var arr = {
                    "sort_by": col,
                    "direction": newDirect,
                    "field": field,
                    "text_search": text_search,
                    "page": number,
                    "amount": 3,
                };
                AjaxRequest(arr);
            });
            
            $(".table").on("click", "thead button", function(e) {
                
                var text = $(this).closest("th").find("input").val();
                $(this).closest('thead').find('input').val('');
                $(this).closest("th").find("input").val(text);
                
                console.log(text);
                
                var arr = {
                    "newDirect": "ASC",
                    "field": $(this).closest("th").attr('name'),
                    "text_search": text,
                    "amount": 3, 
                    "page": 1,
                };
                AjaxRequest(arr);

            });
            
            $(".table").on("click", ".ch", function(e) {
                $(this).closest('thead').find('input').val('');
                
                var newDirect = $(".table").attr("direct");
                var col = $(".table").attr("column");
                
                var this_col = $(this).closest("th").attr("name");
                if (this_col == col) {
                    newDirect = (newDirect == "ASC") ? "DESC" : "ASC";
                }
                else {
                    newDirect = "ASC";
                    col = this_col;
                }
                
                var arr = {
                    "sort_by": col,
                    "direction": newDirect,
                    "e": e,
                    "amount": 3, 
                    "page": 1,
                };
                $(".table").attr("direct", newDirect);
                $(".table").attr("column", col);
                
                AjaxRequest(arr);
                
            });
            var arr = {
                "amount": 3, 
                "page": 1,
            };
            
            AjaxRequest(arr);
            
            function AjaxRequest(o) { 
            
                $.ajax({
                        url: "/ajax",
                        type: "POST",
                        dataType: "json",
                        data: {
                            'sort_by': o.sort_by,
                            "direction": o.direction,
                            "field": o.field,
                            "text_search": o.text_search,
                            "amount": o.amount,
                            "page": o.page, 
                        },
                        async: true,
                        success: function (data)
                        {
                            
                            console.log(data);
                            if (data == "No such page") return;
                            
                            $("tfoot span").text(" " + o.page + " ");
                            console.log(o.page);
                            
                            $(".table > tbody").empty();

                            $(".col2 > div.ch").text('Id ↓');
                            $(".col3 > div.ch").text('Username ↓');
                            $(".col4 > div.ch").text('Email ↓');
                            
                            if (o.e != null) {
                                
                                var str = o.sort_by + ' ↑';

                                if (o.direction == "ASC")
                                    $(o.e.target).text(str);
                            }
                            
                            data.forEach(function(item, i, data) {

                                $('<tr>').append(
                                $('<th>').text(i+1),        
                                $('<td>').text(item.id),
                                $('<td>').text(item.username),
                                $('<td>').text(item.email),
                                ).appendTo('.table  > tbody');

                            });
                        }
                });
            
            }
        };
})
(jQuery);