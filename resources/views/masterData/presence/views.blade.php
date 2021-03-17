
<form action="/admin/presence/processed" method="POST">
@csrf
<button type="submit">Get Processed Data</button>
</form>
<form action="/admin/presence/reset" method="POST">
    @csrf
    <button type="submit">Reset Log presence</button>
    </form>