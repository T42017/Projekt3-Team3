$(document).ready(function () {
    $('#isbn').on('input propertychange paste',function(e){
        var isbn = document.getElementById("isbn").value.replace(/-/g, "");
        
        if (!/^\d+$/.test(isbn) || (isbn.length < 10 || isbn.length > 13))
            return;
        
        $("#search").css('display', 'inline');
        checkISBN(isbn);
    });

    function checkISBN(isbn) {
        $.getJSON("http://libris.kb.se/xsearch?query=" + isbn + "&format=json", function(result){
            $.each(result, function(i, field){
                if (i != "xsearch")
                    return;

                var title = "";
                var publisher = "";
                var language = "";
                var year = "";
                var author = "";

                $.map(field.list, function(value, index) {
                    if (!title && value.title) 
                        title = value.title;

                    if (!author && value.creator)
                        author = value.creator;

                    if (!publisher && value.publisher)
                        publisher = value.publisher;

                    if (!language && value.language)
                        language = value.language;

                    if (!year && value.date)
                        year = value.date.substring(value.date.length - 4, value.date.length);

                    if (title && language && publisher && year && author)
                        return;
                });
                
                if (title)
                    $("#title").val(title);
                if (author)
                    $("#author").val(author);
                if (publisher)
                    $("#publisher").val(publisher);
                if (language)
                    $("#language").val(language);
                if (year)
                    $("#year").val(year);
                
                setTimeout(hideGif, 300);
            });
        });
        
        function hideGif() {
            $("#search").css('display', 'none');
        }
    };
});