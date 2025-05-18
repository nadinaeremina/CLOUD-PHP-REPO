using ApplicantsApi;
using Microsoft.EntityFrameworkCore;

var builder = WebApplication.CreateBuilder(args);

builder.Services.AddDbContext<ApplicationDbContext>();

var app = builder.Build();

app.MapGet("/", () => new {Message = "server is running"});
app.MapGet("/ping", () => new {Message = "pong"});

// при разворачивании этого проекта а докере с нуля - нужно применить миграции: Update-Database
// потому что БД пустая и запросы не выполнятся
// но это делается только при: "UseConnection": "LocalConnection" (в конфиге поменять)
// но контейнер пересобирать не нужно, потому что он запустился с правильной строкой: "UseConnection": "DockerizedConnection"
// просто там табличек не было в БД

// Applicants CRUDs

// GET /applicant
app.MapGet("/applicant", async (ApplicationDbContext db) => await db.Applicants.ToListAsync());

// GET /applicant/{id}
app.MapGet("/applicant/{id:int}", async (int id, ApplicationDbContext db) =>
{
    Applicant? applicant = await db.Applicants.FirstOrDefaultAsync(a => a.Id == id);
    if (applicant == null)
    {
        // 404
        return Results.NotFound();
    }
    // 200
    return Results.Ok(applicant);
});

// POST /applicant
app.MapPost("/applicant", async (ApplicantInfo info, ApplicationDbContext db) =>
{
    Applicant applicant = new Applicant()
    {
        Name = info.Name,
        BirthDate = info.BirthDate,
    };
    await db.AddAsync(applicant);
    await db.SaveChangesAsync();
    // 201
    return Results.Created();
});

// POST /applicant/international
app.MapPost("/applicant/international", async (ApplicantInfo info, ApplicationDbContext db) =>
{
    Applicant applicant = new Applicant()
    {
        Name = info.Name,
        BirthDate = info.BirthDate,
        IsInternational = true
    };
    await db.AddAsync(applicant);
    await db.SaveChangesAsync();
    // 201
    return Results.Created();
});

// DELETE /applicant
app.MapDelete("/applicant/{id:int}", async (int id, ApplicationDbContext db) =>
{
    Applicant? applicant = await db.Applicants.FirstOrDefaultAsync(a => a.Id == id);
    if (applicant == null)
    {
        // 404
        return Results.NotFound();
    }
    db.Applicants.Remove(applicant);
    await db.SaveChangesAsync();
    // 204
    return Results.NoContent();
});


app.Run();

record ApplicantInfo(string Name, DateOnly BirthDate);
