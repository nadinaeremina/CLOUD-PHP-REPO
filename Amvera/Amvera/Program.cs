var builder = WebApplication.CreateBuilder(args);
var app = builder.Build();

app.MapGet("/", () => new { Message = "Server is running" });
app.MapGet("/ping", () => new { Message = "pong" });

app.MapGet("/time-to-new-year", () =>
{
    var currentDate = DateTime.Now;
    var newYearDate = new DateTime(currentDate.Year + 1, 1, 1);
    var toNewYear = newYearDate - currentDate;
    var hours = toNewYear.Days * 24;
    var minutes = hours * 60;

    TimeToNewYear time = new TimeToNewYear(toNewYear.Days, hours, minutes);

    return Results.Ok(time);
});

app.MapGet("/time", () => DateTime.UtcNow);

app.Run();
record TimeToNewYear(int Days, int Hours, int Minutes);
