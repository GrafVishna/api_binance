async function convert() {
   const amount = parseFloat(document.getElementById('amount').value)
   const fromCurrency = document.getElementById('fromCurrency').value
   const toCurrency = document.getElementById('toCurrency').value
   const resultElement = document.getElementById('result')

   try {
      const responseFrom = await fetch(`https://api.frontelf.com/api.php?symbol=${fromCurrency}`)
      const dataFrom = await responseFrom.json()
      const rateFrom = parseFloat(dataFrom.price)

      const responseTo = await fetch(`https://api.frontelf.com/api.php?symbol=${toCurrency}`)
      const dataTo = await responseTo.json()
      const rateTo = parseFloat(dataTo.price)

      if (rateFrom && rateTo) {
         const exchangeRate = rateTo / rateFrom
         const result = amount * exchangeRate
         resultElement.textContent = `Result: ${amount} ${fromCurrency} = ${result} ${toCurrency}`
      } else {
         resultElement.textContent = 'Помилка: Неможливо отримати курси валют.'
      }
   } catch (error) {
      console.error(error)
      resultElement.textContent = `Error: ${error.message}`
   }
}

const convertBtn = document.getElementById('convert')
convertBtn.addEventListener('click', convert)
