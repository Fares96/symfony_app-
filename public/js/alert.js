const clients= document.getElementById('clients') ;
if(clients)
{
    clients.addEventListener('click' , e => { if (e.target.className ==='btn btn-danger delete-client')
    {
        if(confirm('Are you sure you want to delete this client'))
        {
            const id= e.target.getAttribute('data-id') ;
            fetch('/client/delete/${id}', {method : 'DELETE'}).then(res =>window.location.reload()) ;
         }
    }
    });
}