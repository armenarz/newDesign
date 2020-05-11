var sidebarItems = setSidebarItems();

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

function setSidebarItems()
{
    let sidebarItems = $("#sidebar").children();
    let array_ids = [];
    for(let i = 0; i < sidebarItems.length; i++)
    {
        let el = sidebarItems[i];
        array_ids[i] = el.id;
    }
    return array_ids;
}