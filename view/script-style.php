<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          primary: '#164564',
          secondary: '#f0fbfe',
        },
        fontFamily: {
          sans: ['Poppins', 'sans-serif'],
        },
      },
    },
  };
</script>
<style>
  body {
    background-color: #f0fbfe;
    font-family: 'Poppins', sans-serif;
  }

  .input-field {
    transition: all 0.3s ease;
  }

  .input-field:focus {
    border-color: #164564;
    box-shadow: 0 0 0 2px rgba(22, 69, 100, 0.2);
  }

  .btn-primary {
    background-color: #164564;
    transition: all 0.3s ease;
  }

  .btn-primary:hover {
    background-color: #0d3854;
  }

  .toggle-button {
    transition: all 0.3s ease;
    user-select: none;
  }


  .toggle-button.active {
    background-color: #164564;
    color: white;
  }


  .toggle-button:hover {
    background-color: #164564;
    color: white;
    border-color: #164564;
  }

  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: scale(0.95);
    }

    to {
      opacity: 1;
      transform: scale(1);
    }
  }
</style>