{extends 'layouts/plain.tpl'}

{block 'content'}
    <div class="container-fluid mt-2">
        <form action="/login/" method="post">
            <input type="hidden" name="action" value="attemptLogin">
            <input type="text" class="form-control form-control-sm" name="username" required>
            <input type="password" class="form-control form-control-sm mt-2" name="password" required>
            <button type="submit" class="btn btn-success mt-2">Login</button>
        </form>
    </div>
{/block}