function setActiveItem(items, activeItem)
{
    var i;
    for(i = 0; i < items.length; i++)
    {
        if(items[i] == activeItem)
        {
            $("#" + items[i]).addClass("active");
        }
        else
        {
            $("#" + items[i]).removeClass("active");
        }
    }
}