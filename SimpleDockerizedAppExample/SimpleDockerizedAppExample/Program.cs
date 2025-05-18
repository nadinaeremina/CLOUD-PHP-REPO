var builder = WebApplication.CreateBuilder(args);
var app = builder.Build();

app.MapGet("/", (HttpContext context) =>
{
    string part = $"{context.Request.Scheme}://{context.Request.Host}";
    return new Dictionary<string, string>()
    {
        { "/", part },
        { "/ping", $"{part}/ping" },
        { "/info", $"{part}/info" }
    };
});

app.MapGet("/ping", () => new { Message = "pong" });
app.MapGet("/info", () => new {
    Environment.MachineName,
    Environment.OSVersion,
    Environment.CurrentDirectory
});

app.Run();

// ����� ������������� dockerfile - ������� ������ ������� �� ������� - �������� - ��������� docker
// ���������� ��� ������� http ������� ������ dockerfile
// ����� IDE ����� ��������� Container(Docker) - ��������� ����� Visual Code