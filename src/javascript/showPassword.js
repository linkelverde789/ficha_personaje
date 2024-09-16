document.getElementById('first').addEventListener('click', function () { 
    event.preventDefault();
    const field=document.getElementById('password');
    if(field.type==='password'){
        field.type='text';
    }else{
        field.type='password';
    }
});

document.getElementById('second').addEventListener('click', function () { 
    event.preventDefault();
    const field=document.getElementById('confirm');
    if(field.type==='password'){
        field.type='text';
    }else{
        field.type='password';
    }
});