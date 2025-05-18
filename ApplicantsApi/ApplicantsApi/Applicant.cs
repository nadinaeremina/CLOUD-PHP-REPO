namespace ApplicantsApi
{
    // Applicant - абитуриент
    public class Applicant
    {
        public int Id { get; set; }
        public string Name { get; set; } = string.Empty;
        public DateOnly BirthDate { get; set; }
        public bool IsInternational { get; set; }

        public Applicant() { }
    }
}
