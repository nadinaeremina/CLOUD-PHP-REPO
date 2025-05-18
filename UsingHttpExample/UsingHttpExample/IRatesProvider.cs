using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace UsingHttpExample
{
    // IRatesProvider - асинхронный интерфейс, описывающий провайдера курсов валют
    internal interface IRatesProvider
    {
        Task<Dictionary<string, decimal>> GetRates();
    }
}
