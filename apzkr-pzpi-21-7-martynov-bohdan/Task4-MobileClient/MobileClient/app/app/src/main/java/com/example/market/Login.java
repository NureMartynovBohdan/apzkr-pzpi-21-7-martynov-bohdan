package com.example.market;

import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.ProgressBar;
import android.widget.TextView;

import androidx.appcompat.app.AppCompatActivity;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.google.android.material.textfield.TextInputEditText;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

public class Login extends AppCompatActivity {

    TextInputEditText  textInputEditTextClientEmail, textInputEditTextPassword;
    String clientName, clientEmail, password, apiKey;
    Button buttonLogin;
    TextView textViewSignUp, textViewError;
    ProgressBar progressBar;
    SharedPreferences sharedPreferences;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);
        textInputEditTextClientEmail = findViewById(R.id.client_email);
        textInputEditTextPassword = findViewById(R.id.password);
        sharedPreferences = getSharedPreferences("market", MODE_PRIVATE);

        textViewError = findViewById(R.id.error);
        progressBar = findViewById(R.id.progress);

        textViewSignUp = findViewById(R.id.signUpText);
        textViewSignUp.setOnClickListener(v -> {
            Intent intent = new Intent(getApplicationContext(), SignUp.class);
            startActivity(intent);
            finish();
        });

        if(sharedPreferences.getString("logged", "false").equals("true")){
            Intent intent = new Intent(getApplicationContext(), MainActivity.class);
            startActivity(intent);
            finish();
        }

        buttonLogin = findViewById(R.id.buttonLogin);
        buttonLogin.setOnClickListener(view -> {
            clientEmail = String.valueOf(textInputEditTextClientEmail.getText());
            password = String.valueOf(textInputEditTextPassword.getText());
            textViewError.setVisibility(View.GONE);
            progressBar.setVisibility(View.VISIBLE);

            RequestQueue queue = Volley.newRequestQueue(getApplicationContext());
            String url = Url.URL_LOGIN;

            StringRequest stringRequest = new StringRequest(Request.Method.POST, url,
                    response -> {
                        progressBar.setVisibility(View.GONE);
                        try {
                            JSONObject jsonObject = new JSONObject(response);
                            String status = jsonObject.getString("status");
                            String message = jsonObject.getString("message");
                            if (status.equals("success")) {
                                clientName = jsonObject.getString("name");
                                clientEmail = jsonObject.getString("email");
                                apiKey = jsonObject.getString("apiKey");
                                SharedPreferences.Editor editor = sharedPreferences.edit();
                                editor.putString("logged", "true");
                                editor.putString("name", clientName);
                                editor.putString("email", clientEmail);
                                editor.putString("apiKey", apiKey);
                                editor.apply();
                                Intent intent = new Intent(getApplicationContext(), MainActivity.class);
                                startActivity(intent);
                                finish();
                            } else {
                                // Если статус не "success", отобразить сообщение об ошибке
                                textViewError.setText(message);
                                textViewError.setVisibility(View.VISIBLE);
                            }
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }

                    }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    progressBar.setVisibility(View.GONE);
                    textViewError.setText(error.toString());
                    textViewError.setVisibility(View.VISIBLE);
                }
            }){
                protected Map<String, String> getParams(){
                    Map<String, String> paramV = new HashMap<>();
                    paramV.put("email", clientEmail);
                    paramV.put("password", password);
                    return paramV;
                }
            };
            queue.add(stringRequest);

        });

    }
}