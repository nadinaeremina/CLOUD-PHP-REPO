using Microsoft.EntityFrameworkCore;

namespace ApplicantsApi
{
    public class ApplicationDbContext : DbContext 
    {
        public required DbSet<Applicant> Applicants { get; set; }

        protected override void OnConfiguring(DbContextOptionsBuilder optionsBuilder)
        {
            IConfigurationRoot config = new ConfigurationBuilder().AddJsonFile("appsettings.json").Build();
            // находим строку "UseConnection": в файле 'appsettings.json' и смотрим, что в не написано
            string useConnection = config["UseConnection"] ?? "DefaultConnection";
            // если там что-то есть - записали в переменную 'useConnection'
            // создаем 'connectionString' 
            string? connectionString = config.GetConnectionString(useConnection);
            // передаем информацию о строке подключения и подключаемся
            optionsBuilder.UseNpgsql(connectionString);
        }
    }
}