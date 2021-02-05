
<form action="/staff/password/{{$pass->id}}/saved" method="post">
    @csrf
    @method('put')
    <input type="password" name="oldpassword" id="" placeholder="Password Lama">
    <input type="password" name="newpassword" id="">
   <button value="submit">Submit</button>
   {{
   
   dd(App\User::where('id',[$pass->id])->get())}}
</form>